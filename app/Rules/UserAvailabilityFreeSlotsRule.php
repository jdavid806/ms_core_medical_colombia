<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserAvailabilityFreeSlotsRule implements ValidationRule
{
    private $startTime;
    private $endTime;

    public function __construct($startTime = null, $endTime = null)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($value as $slot) {
            if (!isset($slot['start_time'], $slot['end_time'])) {
                $fail("Cada espacio libre debe tener una hora de inicio y fin.");
                return;
            }

            if ($this->startTime && $slot['start_time'] < $this->startTime) {
                $fail("El espacio libre {$slot['start_time']} - {$slot['end_time']} comienza antes del horario de atención.");
                return;
            }

            if ($this->endTime && $slot['end_time'] > $this->endTime) {
                $fail("El espacio libre {$slot['start_time']} - {$slot['end_time']} termina después del horario de atención.");
                return;
            }

            if ($slot['start_time'] >= $slot['end_time']) {
                $fail("El espacio libre {$slot['start_time']} - {$slot['end_time']} tiene una hora de inicio posterior o igual a la hora de fin.");
                return;
            }
        }

        usort($value, fn($a, $b) => strcmp($a['start_time'], $b['start_time']));
        for ($i = 1; $i < count($value); $i++) {
            if ($value[$i]['start_time'] < $value[$i - 1]['end_time']) {
                $fail("Los espacios libres no deben solaparse. Conflicto entre {$value[$i - 1]['start_time']} - {$value[$i - 1]['end_time']} y {$value[$i]['start_time']} - {$value[$i]['end_time']}.");
                return;
            }
        }
    }
}
