<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\AppointmentState;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckMissedAppointments implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $currentDateTime = Carbon::now();

        // Obtener el estado "inasistencia" (asegurando que existe en la base de datos)
        $missedState = AppointmentState::where('name', 'non-attendance')->first();

        if (!$missedState) {
            return; // Finalizar si no se encuentra el estado "non-attendance"
        }

        // Calcular el rango de tiempo límite
        $timeLimit = $currentDateTime->copy()->addMinutes(30);

        // Buscar citas pendientes dentro del rango de tiempo y sin tickets asociados
        $pendingAppointments = Appointment::whereHas('appointmentState', function ($query) {
            $query->where('name', 'pending');
        })
            ->whereDate('appointment_date', '<=', $currentDateTime->toDateString()) // Fecha de la cita
            ->whereTime('appointment_time', '<=', $timeLimit->toTimeString()) // Hora de la cita
            ->whereDoesntHave('tickets') // Filtrar citas sin tickets asociados
            ->get();

        // Actualizar el estado de las citas encontradas a "non-attendance"
        foreach ($pendingAppointments as $appointment) {
            $appointment->update([
                'appointment_state_id' => $missedState->id
            ]);
        }
    }
}
