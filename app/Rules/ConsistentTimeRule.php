<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ConsistentTimeRule implements ValidationRule
{
    private $existingStartTime;
    private $existingEndTime;

    public function __construct($existingStartTime, $existingEndTime)
    {
        $this->existingStartTime = $existingStartTime;
        $this->existingEndTime = $existingEndTime;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($attribute === 'start_time' && $value >= $this->existingEndTime) {
            $fail("La hora de inicio es posterior o igual a la hora final guardada actualmente.");
        }

        if ($attribute === 'end_time' && $value <= $this->existingStartTime) {
            $fail("La hora final es anterior o igual a la hora de inicio guardada actualmente.");
        }
    }
}
