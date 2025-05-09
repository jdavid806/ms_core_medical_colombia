<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class PatientEducatorJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected int $appointmentId) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $appointment = $this->getAppointment();
        $patient = $appointment->patient;
        $tenant = $this->getTenant();
        $company = $this->getCompany();

        $formattedRecipes = $this->getFormattedRecipes($patient, $appointment);
        $diagnostic = $this->getDiagnostic($appointment);

        $responseData = $this->buildResponseData($patient, $formattedRecipes, $diagnostic, $tenant, $company);
        $this->sendWebhook($responseData);
    }

    // Métodos auxiliares

    private function getAppointment(): Appointment
    {
        return Appointment::with(['patient'])->findOrFail($this->appointmentId);
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

        return $recipes->flatMap(function ($recipe) {
            return $recipe->recipeItems->map(function ($item) {
                return $item->medication . ' ' . $item->concentration;
            });
        });
    }

    private function getDiagnostic(Appointment $appointment): string
    {
        $clinicalRecord = $appointment->clinicalRecords()->first();
        return optional($clinicalRecord)->data['rips']['diagnosticoPrincipal'] ?? 'Diagnóstico no disponible';
    }

    private function buildResponseData(Patient $patient, $formattedRecipes, $diagnostic, $tenant, $company): array
    {
        return [
            'paciente_id' => $patient->id,
            'nombre' => $patient->full_name,
            'edad' => Carbon::parse($patient->date_of_birth)->age . ' años',
            'sexo' => $patient->gender,
            'diagnostico' => $diagnostic,
            'medicamentos' => $formattedRecipes,
            'nivel_educativo' => $patient->educational_level,
            'canal' => 'whatsapp',
            'tenant' => $tenant->tenancy_db_name,
            'nombre_centro' => $company->legal_name,
            'cod_pais' => "57",
            'whatsapp' => $patient->whatsapp,
        ];
    }

    private function sendWebhook(array $responseData): void
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
