<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\UserAvailability;
use Carbon\Carbon;

class UserAvailabilityNoOverlapRule implements ValidationRule
{
    protected $startTime;
    protected $endTime;
    protected $daysOfWeek;
    protected $userId;
    protected $currentId; // Id del registro que se está editando (opcional)

    public function __construct($startTime, $endTime, $daysOfWeek, $userId, $currentId = null)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->daysOfWeek = $daysOfWeek;
        $this->userId = $userId;
        $this->currentId = $currentId;
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        try {
            $newStart = Carbon::createFromFormat('H:i:s', $this->startTime);
            $newEnd   = Carbon::createFromFormat('H:i:s', $this->endTime);
        } catch (\Exception $e) {
            return;
        }

        $newDays = is_array($this->daysOfWeek)
            ? $this->daysOfWeek
            : json_decode($this->daysOfWeek, true);
        if (!is_array($newDays)) {
            $fail('El formato de los días de la semana es inválido.');
            return;
        }

        $availabilities = UserAvailability::where('user_id', $this->userId)
            ->where('is_active', true)
            ->get();

        foreach ($availabilities as $availability) {
            // Si se está editando un registro, se ignora él mismo.
            if ($this->currentId && $availability->id == $this->currentId) {
                continue;
            }

            $existingDays = is_array($availability->days_of_week)
                ? $availability->days_of_week
                : json_decode($availability->days_of_week, true);

            if (!is_array($existingDays)) {
                continue;
            }

            $commonDays = array_intersect($newDays, $existingDays);
            if (empty($commonDays)) {
                continue;
            }

            try {
                $existingStart = Carbon::createFromFormat('H:i:s', $availability->start_time);
                $existingEnd   = Carbon::createFromFormat('H:i:s', $availability->end_time);
            } catch (\Exception $e) {
                continue;
            }

            // Se detecta solapamiento si el nuevo horario inicia antes de que finalice el existente
            // y finaliza después de que inicia el existente.
            if ($newStart->lt($existingEnd) && $newEnd->gt($existingStart)) {
                $fail('El horario de atención se solapa con otro existente en los días: ' . implode(', ', $commonDays));
                return;
            }
        }
    }
}
