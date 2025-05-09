<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Patient;
use Illuminate\Console\Command;
use App\Models\ChronicCondition;
use Illuminate\Support\Facades\Http;

class SendChronicPatientsReminder extends Command
{

    protected $signature = 'app:send-chronic-patients-reminder';


    protected $description = 'Command description';

    public function handle()
    {
        $chronicCodes = ChronicCondition::pluck('cie11_code')->toArray();

        Patient::with(['clinicalRecords', 'appointments'])
            ->where('is_active', true)
            ->chunk(100, function ($patients) use ($chronicCodes) {
                foreach ($patients as $patient) {
                    foreach ($patient->clinicalRecords as $record) {
                        $cie11 = data_get($record->data, 'rips.diagnosticoPrincipal');


                        if (!$cie11 || !in_array($cie11, $chronicCodes)) {

                            continue;
                        }


                        $lastAppointment = $patient->appointments->sortByDesc('appointment_date')->first(); // asegúrate de tener un campo `date`


                        if (!$lastAppointment) continue;

                        $lastDate = Carbon::parse($lastAppointment->date);
                        $daysSince = $lastDate->diffInDays(now());

                        if (in_array($daysSince, [30, 60, 90])) {
                            $this->enviarWebhook($patient, $cie11, $lastDate, $daysSince);
                        }


                        break; // si ya encontramos un diagnóstico crónico, no seguimos buscando más
                    }
                }
            });

        $this->info('Recordatorios procesados.');
    }

    private function enviarWebhook($patient, $cie11, $lastDate, $daysSince)
    {
        $webhookUrl = config('services.webhooks.n8n-seguimiento-cronico'); // URL específica para este webhook

        $payload = [
            "paciente_id" => $patient->id,
            "nombre" => "{$patient->first_name} {$patient->middle_name} {$patient->last_name} {$patient->second_last_name}",
            "edad" => \Carbon\Carbon::parse($patient->date_of_birth)->age,
            "diagnostico" => $cie11,
            "ultima_cita" => $lastDate->toDateString(),
            "dias_desde_ultima_cita" => $daysSince,
            "frecuencia_control_dias" => $daysSince,
            "tenant" => "cenode",
            "nombre_centro" => "centro orienta del diabetes y endocrinologia",
            "cod_pais" => "+1 809",
            "whatsapp" => $patient->whatsapp,
            "correo" => $patient->email,
        ];

        Http::post($webhookUrl, $payload); // Enviar el POST al webhook específico
    }
}
