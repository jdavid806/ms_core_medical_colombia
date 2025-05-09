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

class AppointmentConfirmationAdvancePaymentJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected int $appointmentId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $appointment = $this->getAppointment();

        $patient = $appointment->patient;

        $tenant = $this->getTenant();

        $company = $this->getCompany();
        
        $responseData = $this->buildResponseData($patient, $appointment, $tenant, $company);

        $this->sendWebhook($responseData);
        
    }

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

    private function buildResponseData(Patient $patient, Appointment $appointment, $tenant, $company): array
    {
        return [
            'paciente_id' => $patient->id,
            'nombre' => $patient->full_name,
            'fecha' => $appointment->appointment_date,
            'hora' => $appointment->appointment_time,
            'medico' => $appointment->assignedUserAvailability->user->full_name,
            'especialidad' => $appointment->assignedUserAvailability->user->specialty->name,
            "enlace_pago" =>  "https://pagos.medicalsoft.com/pagar/654",
            'edad' => Carbon::parse($patient->date_of_birth)->age . ' anos',
            'sexo' => $patient->gender,
            'canal' => 'whatsapp',
            "tenant" => $tenant->tenancy_db_name,
            "nombre_centro" => $company->legal_name,
            "cod_pais" => "57",
            "whatsapp" => $patient->whatsapp,
        ];
    }

    private function sendWebhook(array $responseData): void
    {
        $webhookUrl = config('services.webhooks.n8n-resumen-historia-clinica');
        $response = Http::post($webhookUrl, $responseData);

        // Revisa si la petición fue exitosa
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
