<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Appointment;
use App\Models\UserAbsence;
use App\Models\UserAvailability;
use Carbon\Carbon;

class NoAppointmentConflictRule implements ValidationRule
{
    protected $appointmentDate;
    protected $appointmentTime;
    protected $assignedUserAvailabilityId;
    protected $currentId; // ID de la cita actual (opcional)
    public function __construct($appointmentDate, $appointmentTime, $assignedUserAvailabilityId, $currentId = null)
    {
        $this->appointmentDate = $appointmentDate;
        $this->appointmentTime = $appointmentTime;
        $this->assignedUserAvailabilityId = $assignedUserAvailabilityId;
        $this->currentId = $currentId;
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        // Buscar la disponibilidad del usuario
        $userAvailability = UserAvailability::find($this->assignedUserAvailabilityId);
        if (!$userAvailability) {
            $fail('La disponibilidad de usuario no existe.');
            return;
        }

        // Verificar que el día de la cita esté en los días laborales del usuario
        $appointmentDate = Carbon::parse($this->appointmentDate);
        $dayOfWeek = $appointmentDate->dayOfWeek; // 0 (domingo) a 6 (sábado)

        $daysOfWeek = $userAvailability->days_of_week ?? [];
        if (!is_array($daysOfWeek)) {
            $daysOfWeek = json_decode($daysOfWeek, true) ?? [];
        }

        if (!in_array($dayOfWeek, $daysOfWeek)) {
            $dayNames = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
            $fail('El usuario no trabaja el día ' . $dayNames[$dayOfWeek]);
            return;
        }

        // Validar que la fecha de la cita no esté dentro de las ausencias del usuario
        $absences = UserAbsence::where('user_id', $userAvailability->user_id)
            ->where('start_date', '<=', $this->appointmentDate)
            ->where('end_date', '>=', $this->appointmentDate)
            ->where('is_active', true)
            ->get();

        if ($absences->isNotEmpty()) {
            $fail('El usuario no estará disponible en la fecha ' . $this->appointmentDate . '.');
            return;
        }

        // Se asume que la duración de la cita se define en la disponibilidad
        $appointmentDuration = $userAvailability->appointment_duration;

        // Definir el intervalo de la nueva cita
        try {
            $newAppointmentStart = Carbon::createFromFormat('H:i:s', $this->appointmentTime);
        } catch (\Exception $e) {
            $fail('El formato de la hora de la cita es inválido.');
            return;
        }
        $newAppointmentEnd = $newAppointmentStart->copy()->addMinutes($appointmentDuration);

        // Validar que la cita esté dentro del horario de atención
        try {
            $availabilityStart = Carbon::createFromFormat('H:i:s', $userAvailability->start_time);
            $availabilityEnd   = Carbon::createFromFormat('H:i:s', $userAvailability->end_time);
        } catch (\Exception $e) {
            $fail('El formato de la hora de la disponibilidad es inválido.');
            return;
        }
        if ($newAppointmentStart->lt($availabilityStart) || $newAppointmentEnd->gt($availabilityEnd)) {
            $fail('La cita debe estar dentro del horario de atención definido (de ' . $availabilityStart->format('H:i:s') . ' a ' . $availabilityEnd->format('H:i:s') . ').');
            return;
        }

        // Validar solapamiento con otras citas existentes (ignorando la cita actual si se proporciona el ID)
        $existingAppointments = Appointment::where('assigned_user_availability_id', $this->assignedUserAvailabilityId)
            ->where('appointment_date', $this->appointmentDate)
            ->when($this->currentId, function ($query) {
                $query->where('id', '<>', $this->currentId);
            })
            ->get();

        foreach ($existingAppointments as $appointment) {
            try {
                $existingAppointmentStart = Carbon::createFromFormat('H:i:s', $appointment->appointment_time);
            } catch (\Exception $e) {
                continue;
            }
            $existingAppointmentEnd = $existingAppointmentStart->copy()->addMinutes($appointmentDuration);

            if ($newAppointmentStart->lt($existingAppointmentEnd) && $newAppointmentEnd->gt($existingAppointmentStart)) {
                $fail('La cita entra en conflicto con otra existente.');
                return;
            }
        }

        // Validar solapamiento con los espacios libres configurados en la disponibilidad
        $freeSlots = $userAvailability->freeSlots;
        if (!is_array($freeSlots)) {
            $freeSlots = json_decode($freeSlots, true);
        }
        if (is_array($freeSlots)) {
            foreach ($freeSlots as $slot) {
                // Se asume que cada slot tiene 'start_time' y 'end_time'
                try {
                    $freeStart = Carbon::createFromFormat('H:i:s', $slot['start_time']);
                    $freeEnd   = Carbon::createFromFormat('H:i:s', $slot['end_time']);
                } catch (\Exception $e) {
                    continue; // Ignoramos este espacio libre si el formato es incorrecto
                }

                if ($newAppointmentStart->lt($freeEnd) && $newAppointmentEnd->gt($freeStart)) {
                    $fail('La cita entra en conflicto con un espacio libre configurado (de ' . $freeStart->format('H:i:s') . ' a ' . $freeEnd->format('H:i:s') . ').');
                    return;
                }
            }
        }
    }
}
