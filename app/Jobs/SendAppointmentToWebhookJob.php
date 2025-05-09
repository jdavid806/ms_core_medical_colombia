<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\AiResponse;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendAppointmentToWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $appointmentId;

    public function __construct(int $appointmentId)
    {
        $this->appointmentId = $appointmentId;
    }

    public function handle(): void
    {
        $appointment = $this->getAppointment();
        $patient = $this->getPatient($appointment->patient_id);

        $recentClinicalRecords = $this->getRecentClinicalRecords($patient);
        $antecedentes = $this->getAntecedentes($patient);
        $consultasRecientes = $this->compileRecentConsultations($recentClinicalRecords, $patient);
        $resumenes = $this->getAgentSummaries($patient);

        $responseData = $this->formatResponseData($patient, $antecedentes, $consultasRecientes, $resumenes);
        $this->sendWebhook($responseData);
    }

    private function getAppointment(): Appointment
    {
        return Appointment::with('patient')->findOrFail($this->appointmentId);
    }

    private function getPatient(int $patientId): Patient
    {
        return Patient::with([
            'clinicalRecords',
            'disabilities',
            'nursingNotes',
            'vaccineApplications',
            'appointments',
            'exams',
            'evolutionNotes',
            'admissions',
            'examRecipes',
        ])->findOrFail($patientId);
    }

    private function getRecentClinicalRecords(Patient $patient)
    {
        return $patient->clinicalRecords()
            ->whereHas('clinicalRecordType', fn($q) => $q->where('name', '!=', 'Antecedentes'))
            ->latest()
            ->take(5)
            ->get();
    }

    private function getAntecedentes(Patient $patient)
    {
        $record = $patient->clinicalRecords()
            ->whereHas('clinicalRecordType', fn($q) => $q->where('name', 'Antecedentes'))
            ->latest()
            ->first();

        return collect(optional($record)->data ?? [])
            ->filter(fn($value) => !is_null($value))
            ->mapWithKeys(fn($value, $key) => [$key => strip_tags($value)]);
    }

    private function compileRecentConsultations($recentClinicalRecords, Patient $patient)
    {
        return $recentClinicalRecords->map(function ($record) use ($patient) {
            $data = collect($record->data ?? []);

            return [
                'historia_clinica' => $this->processClinicalRecord($record),
                'incapacidades' => $this->processDisabilities($patient),
                'notas_enfermeria' => $this->processNursingNotes($patient),
                'aplicaciones_vacunas' => $this->processVaccineApplications($patient),
                'citas' => $this->processAppointments($patient),
                'examenes' => $this->processExams($patient),
                'notas_evolucion' => $this->processEvolutionNotes($patient),
                'admissions' => $this->processAdmissions($patient),
                'examen_recetas' => $this->processExamRecipes($patient),
            ];
        });
    }

    private function processClinicalRecord($record)
    {
        $data = collect($record->data ?? []);
        return [
            'clinical_record_id' => $record->id,
            'clinical_record_type' => $record->clinicalRecordType->name ?? null,
            'fecha' => $record->created_at->toDateString(),
            'rips' => $this->cleanHtmlTags($data->get('rips')),
            'values' => $this->cleanHtmlTags($data->get('values')),
            'receta' => $this->filterNonEmpty($data->get('receta')),
        ];
    }

    private function cleanHtmlTags($data)
    {
        return collect($data)->filter(fn($value) => !is_null($value))->mapWithKeys(fn($value, $key) => [$key => strip_tags($value)]);
    }

    private function filterNonEmpty($data)
    {
        return collect($data)->filter(fn($item) => is_array($item) && !empty(array_filter($item, fn($value) => !is_null($value))));
    }

    private function processDisabilities(Patient $patient)
    { /* Similar to notas_enfermeria */
    }
    private function processNursingNotes(Patient $patient)
    { /* Similar approach */
    }
    private function processVaccineApplications(Patient $patient)
    { /* Similar approach */
    }
    private function processAppointments(Patient $patient)
    { /* Similar approach */
    }
    private function processExams(Patient $patient)
    { /* Similar approach */
    }
    private function processEvolutionNotes(Patient $patient)
    { /* Similar approach */
    }
    private function processAdmissions(Patient $patient)
    { /* Similar approach */
    }
    private function processExamRecipes(Patient $patient)
    { /* Similar approach */
    }

    private function getAgentSummaries(Patient $patient)
    {
        return AiResponse::where('responsable_id', $patient->id)
            ->where('responsable_type', Patient::class)
            ->where('agent_id', 2)
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn($resumen) => [
                'agente' => $resumen->agent->name,
                'respuesta' => ['mensaje' => $resumen->response['mensaje']],
                'status' => $resumen->status,
                'created_at' => Carbon::parse($resumen->created_at)->format('d-m-Y H:i:s'),
            ]);
    }

    private function formatResponseData(Patient $patient, $antecedentes, $consultasRecientes, $resumenes)
    {
        return [
            'paciente_id' => $patient->id,
            'nombre' => $patient->full_name,
            'edad' => Carbon::parse($patient->date_of_birth)->age,
            'sexo' => $patient->gender,
            'antecedentes' => $antecedentes,
            'consultas_recientes' => $consultasRecientes,
            'resumenes_recientes' => $resumenes,
        ];
    }

    private function sendWebhook($responseData)
    {
        $webhookUrl = config('services.webhooks.n8n-resumen-historia-clinica');
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
