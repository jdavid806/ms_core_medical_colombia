<?php

namespace App\Enum;

enum GenderEnum: string
{
    case MALE  = 'Masculino';
    case FEMALE = 'Femenino';
    case INDETERMINATE = 'Indeterminado';
    case OTHER = 'Otro';

    public function getLabel(): ?string
    {
        return $this->name;

        return match ($this) {
            self::MALE => 'Masculino',
            self::FEMALE => 'Femenino',
            self::INDETERMINATE => 'Indeterminado',
            self::OTHER => 'Otro'
        };
    }
}
