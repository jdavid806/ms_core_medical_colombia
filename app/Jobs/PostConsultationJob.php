<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Patient;
use App\Models\AiResponse;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostConsultationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected int $appointmentId)
    {
        //
    }

    private function getClinicalSummary(Patient $patient, Appointment $appointment)
    {
        $clinicalRecord = $appointment->clinicalRecords()
            ->orderBy('created_at', 'desc')
            ->first();
    
        $historiaClinica = [];
        if ($clinicalRecord) {
            $data = collect($clinicalRecord->data ?? []);
    
            $rips = collect($data->get('rips', []))
                ->filter(fn($value) => !is_null($value))
                ->mapWithKeys(fn($value, $key) => [$key => strip_tags($value)]);
    
            $values = collect($data->get('values', []))
                ->filter(fn($value) => !is_null($value))
                ->mapWithKeys(fn($value, $key) => [$key => strip_tags($value)]);
    
            $receta = collect($data->get('receta', []))
                ->filter(fn($item) => is_array($item) && !empty(array_filter($item, fn($value) => !is_null($value))));
    
            $historiaClinica = [
                'clinical_record_id' => $clinicalRecord->id,
                'clinical_record_type' => $clinicalRecord->clinicalRecordType->name ?? null,
                'fecha' => $clinicalRecord->created_at->toDateString(),
                'rips' => $rips,
                'values' => $values,
            ];
    
            if ($receta->isNotEmpty()) {
                $historiaClinica['receta'] = $receta->toArray();
            }
    
            $historiaClinica['notas_enfermeria'] = $patient->nursingNotes->map(function ($note) {
                return [
                    'user' => optional($note->user)->full_name,
                    'note' => strip_tags($note->note),
                    'is_active' => $note->is_active,
                ];
            });
    
            $historiaClinica['aplicaciones_vacunas'] = $patient->vaccineApplications->map(function ($application) {
                return [
                    'group_vaccine' => optional($application->groupVaccine)->name,
                    'applied_by_user' => optional($application->appliedByUser)->full_name,
                    'dose_number' => $application->dose_number,
                    'is_booster' => $application->is_booster,
                    'description' => strip_tags($application->description),
                    'application_date' => $application->application_date,
                    'next_application_date' => $application->next_application_date,
                    'is_active' => $application->is_active,
                ];
            });
    
            $historiaClinica['incapacidades'] = $patient->disabilities->map(function ($disability) {
                return [
                    'user' => optional($disability->user)->full_name,
                    'start_date' => $disability->start_date,
                    'end_date' => $disability->end_date,
                    'reason' => strip_tags($disability->reason),
                    'is_active' => $disability->is_active,
                ];
            });
    
            $historiaClinica['citas'] = $patient->appointments->map(function ($appointment) {
                return [
                    'assigned_user_availability' => optional($appointment->userAvailability->user)->full_name,
                    'created_by_user' => optional($appointment->createdByUser)->full_name,
                    'appointment_state' => optional($appointment->appointmentState)->name,
                    'appointment_time' => $appointment->appointment_time,
                    'appointment_date' => $appointment->appointment_date,
                    'attention_type' => $appointment->attention_type,
                    'consultation_purpose' => $appointment->consultation_purpose,
                    'consultation_type' => $appointment->consultation_type,
                    'external_cause' => $appointment->external_cause,
                    'is_active' => $appointment->is_active,
                    'product_id' => $appointment->product_id,
                    'supervisor_user_id' => $appointment->supervisorUser?->full_name,
                ];
            });
    
            $historiaClinica['examenes'] = $patient->exams->map(function ($exam) {
                return [
                    'name' => $exam->name,
                    'result' => $exam->result,
                    'date' => $exam->date,
                    'is_active' => $exam->is_active,
                ];
            });
    
            $historiaClinica['notas_evolucion'] = $patient->evolutionNotes->map(function ($note) {
                return [
                    'user' => optional($note->user)->full_name,
                    'note' => strip_tags($note->note),
                    'is_active' => $note->is_active,
                ];
            });
    
            $historiaClinica['admissions'] = $patient->admissions->map(function ($admission) {
                return [
                    'admission_type' => $admission->admissionType->name,
                    'admission_date' => $admission->admission_date,
                    'discharge_date' => $admission->discharge_date,
                    'is_active' => $admission->is_active,
                ];
            });
    
            $historiaClinica['examen_recetas'] = $patient->examRecipes->map(function ($exam) {
                return [
                    'name' => $exam->name,
                    'result' => $exam->result,
                    'date' => $exam->date,
                    'is_active' => $exam->is_active,
                ];
            });
        }
    
        return $historiaClinica;
    }
    
    private function getRecentSummaries(Patient $patient)
    {
        return AiResponse::where('responsable_id', $patient->id)
            ->where('responsable_type', Patient::class)
            ->where('agent_id', 2)
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($resumen) {
                return [
                    'agente' => $resumen->agent->name,
                    'respuesta' => [
                        'mensaje' => $resumen->response['mensaje'],
                    ],
                    'status' => $resumen->status,
                    'created_at' => Carbon::parse($resumen->created_at)->format('d-m-Y H:i:s'),
                ];
            });
    }
    
    public function handle()
    {
        $appointment = $this->getAppointment();
        $patient = $appointment->patient;
        $tenant = $this->getTenant();
        $company = $this->getCompany();
    
        $formattedRecipes = $this->getFormattedRecipes($patient, $appointment);
        $diagnostic = $this->getDiagnostic($appointment);
        $clinicalSummary = $this->getClinicalSummary($patient, $appointment);
        $recentSummaries = $this->getRecentSummaries($patient);
    
        $responseData = $this->buildResponseData($patient, $appointment, $formattedRecipes, $diagnostic, $tenant, $company);
        $responseData['resumen_clinico'] = $clinicalSummary ?? 'Resumen clínico no disponible';
        $responseData['resumenes_recientes'] = $recentSummaries;
    
        $this->sendWebhook($responseData);
    }

    // Métodos auxiliares

    private function getAppointment(): Appointment
    {
        return Appointment::with(['patient', 'clinicalRecords', 'assignedUserAvailability.user.specialty'])->findOrFail($this->appointmentId);
    }

    private function getTenant()
    {
        return tenancy()->tenant;
    }

    private function getCompany(): Company
    {
        return Company::all()->first();
    }

    private function getFormattedRecipes(Patient $patient, Appointment $appointment)
    {
        $recipes = $patient->recipes()->where('appointment_id', $appointment->id)->with('recipeItems')->get();

        return $recipes->map(function ($recipe) {
            return [
                'prescriber' => optional($recipe->prescriber)->full_name,
                'items' => $recipe->recipeItems->map(function ($item) {
                    return [
                        'medication' => $item->medication,
                        'concentration' => $item->concentration,
                        'frequency' => $item->frequency,
                        'duration' => $item->duration,
                        'medication_type' => $item->medication_type,
                        'take_every_hours' => $item->take_every_hours,
                        'quantity' => $item->quantity,
                        'observations' => $item->observations,
                    ];
                }),
            ];
        });
    }

    private function getDiagnostic(Appointment $appointment)
    {
        $clinicalRecord = $appointment->clinicalRecords()
        ->orderBy('created_at', 'desc') // Orden descendente por fecha de creación
        ->first();
        return optional($clinicalRecord)->data['rips']['diagnosticoPrincipal'] ?? 'Diagnóstico no disponible';
    }

    private function buildResponseData(Patient $patient, Appointment $appointment, $formattedRecipes, $diagnostic, $tenant, $company): array
    {
        return [
            'paciente_id' => $patient->id,
            'nombre' => $patient->full_name,
            'edad' => Carbon::parse($patient->date_of_birth)->age . ' años',
            'sexo' => $patient->gender,
            'diagnostico' => $diagnostic,
            'receta' => $formattedRecipes,
            'medico' => $appointment->assignedUserAvailability->user->full_name,
            'especialidad' => $appointment->assignedUserAvailability->user->specialty->name,
            'tenant' => $tenant->tenancy_db_name,
            'nombre_centro' => $company->legal_name,
            'cod_pais' => "57",
            'whatsapp' => $patient->whatsapp,
        ];
    }

    private function sendWebhook(array $responseData): void
    {
        $webhookUrl = config('services.webhooks.n8n-educar-paciente');
        $response = Http::post($webhookUrl, $responseData);

        if ($response->successful()) {
            Log::info('Webhook enviado correctamente.', ['response' => $response->json()]);
        } else {
            Log::error('Error al enviar webhook.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }
    }
}
