<?php

namespace App\Jobs;

use App\Models\Survey;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;

class SendSurveyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $appointmentId;
    public int $attempt;

    public function __construct(int $appointmentId, int $attempt = 1)
    {
        $this->appointmentId = $appointmentId;
        $this->attempt = $attempt;
    }

    public function handle()
    {
        $appointment = $this->getAppointment();

        if (!$appointment) return;

        // Verificamos si ya hay una encuesta respondida
        $survey = $appointment->surveyResponse; // asumiendo una relación
        if ($survey && $survey->respuesta) {

            $responseData = [
                'cita_id' => $appointment->id,
                'paciente_id' => $appointment->patient->id,
                'nombre' => $appointment->patient->full_name,
                'medico' => $appointment->assignedUserAvailability->user->full_name,
                'especialidad' => $appointment->assignedUserAvailability->user->specialty->name,
                'respuesta' => $survey->respuesta,
                'canal' => 'whatsapp'
            ];
            // Enviar webhook a n8n
            $this->sendWebhook($responseData);
            Log::info("Encuesta respondida enviada a paciente ID {$appointment->patient->id} para cita ID {$appointment->id}");
            
        }

        // Reintento condicional
        if ($this->attempt < 4) {
            $delays = [ // minutos
                1 => now()->addMinutes(120),
                2 => now()->addHours(22),  // total 24h desde anterior
                3 => now()->addHours(12),  // total 36h desde inicial
            ];

            SendSurveyJob::dispatch($this->appointmentId, $this->attempt + 1)
                ->delay($delays[$this->attempt]);
        }

        // Si es el primer intento, enviamos la encuesta ahora
        if ($this->attempt === 1) {
            // Aquí puedes reutilizar el código de confirmacionCita() si quieres personalizar
            // el contenido del mensaje de encuesta o simplemente registrarla
            Log::info("Encuesta enviada a paciente ID {$appointment->patient->id} para cita ID {$appointment->id}");
            // Ejemplo: crear el registro de encuesta pendiente
            Survey::create([
                'appointment_id' => $appointment->id,
                'status' => 'pending',
                'sent_at' => now(),
            ]);
        }
    }

    private function getAppointment(): Appointment
    {
        return Appointment::with('patient')->findOrFail($this->appointmentId);
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

