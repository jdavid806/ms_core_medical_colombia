<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SendHistoricalReportToWebhook extends Command
{
    protected $signature = 'report:historical';

    protected $description = 'Analiza las atenciones y envía un resumen al webhook de n8n';

    public function handle()
    {
        $this->info('Generando reporte histórico...');

        $appointments = Appointment::with([
            'assignedUserAvailability.user.specialty',
            'patient'
        ])
        ->whereNotNull('appointment_date')
        ->get()
        ->filter(fn ($appt) => optional($appt->assignedUserAvailability?->user?->specialty)->is_active)
        ->groupBy(function ($appt) {
            return optional($appt->assignedUserAvailability->user->specialty)->name;
        });

        $specialtyDemand = $appointments->map(fn ($group, $specialty) => [
            'especialidad' => $specialty,
            'total' => $group->count()
        ])->values();

        $mostDemanded = $specialtyDemand->sortByDesc('total')->take(3)->values();
        $leastDemanded = $specialtyDemand->sortBy('total')->take(3)->values();

        $ageGroups = [
            'Niños 0-8 años' => [0, 8],
            'Niños 9-16 años' => [9, 16],
            'Jóvenes 17-30 años' => [17, 30],
            'Adultos 31-45 años' => [31, 45],
            'Adultos mayores 46-60 años' => [46, 60],
            'Mayores de 61 años' => [61, 120],
        ];

        $now = now();
    
        $patients = Appointment::with('patient')->get()->pluck('patient')->filter();
    
        $grouped = collect($patients)->map(function ($patient) use ($now, $ageGroups) {
            $age = Carbon::parse($patient->birthdate)->age ?? null;
            $groupLabel = 'Sin edad';
    
            foreach ($ageGroups as $label => [$min, $max]) {
                if ($age >= $min && $age <= $max) {
                    $groupLabel = $label;
                    break;
                }
            }
    
            return [
                'group' => "{$patient->gender} {$groupLabel}",
            ];
        })->groupBy('group')->map(fn($items, $group) => [
            'grupo' => $group,
            'frecuencia' => count($items)
        ])->sortByDesc('frecuencia')->take(3)->values();
    
        // Fechas con mayor demanda
        $topDates = Appointment::select('appointment_date', DB::raw('count(*) as total'))
            ->groupBy('appointment_date')
            ->orderByDesc('total')
            ->limit(3)
            ->pluck('appointment_date');
    
        // Horas con mayor y menor demanda
        $timeDemand = Appointment::select('appointment_time', DB::raw('count(*) as total'))
            ->whereNotNull('appointment_time')
            ->groupBy('appointment_time')
            ->orderByDesc('total')
            ->get();
    
        $topHours = $timeDemand->take(3)->map(function ($item) {
            return [
                'hora' => $item->appointment_time,
                'total' => $item->total
            ];
        });
    
        $leastHours = $timeDemand->sortBy('total')->take(3)->values()->map(function ($item) {
            return [
                'hora' => $item->appointment_time,
                'total' => $item->total
            ];
        });
    
        return response()->json([
            'servicios_mas_demandados' => $mostDemanded,
            'servicios_menos_demandados' => $leastDemanded,
            'top_perfiles' => $grouped,
            'fechas_con_mayor_demanda' => $topDates,
            'horas_mayor_demanda' => $topHours,
            'horas_menor_demanda' => $leastHours,
        ]);

        $webhookUrl = config('services.webhooks.n8n-inteligencia-comercial');

        $response = Http::post($webhookUrl, $responseData);

        if ($response->successful()) {
            Log::info('Webhook enviado correctamente.', ['response' => $response->json()]);
            $this->info('✅ Webhook enviado con éxito');
        } else {
            Log::error('Error al enviar webhook.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            $this->error('❌ Error al enviar webhook');
        }
    }
}
