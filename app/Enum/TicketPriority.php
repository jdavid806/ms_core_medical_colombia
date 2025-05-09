<?php

namespace App\Enum;

enum TicketPriority: string
{
    case NONE = 'NONE';
    case SENIOR = 'SENIOR';
    case PREGNANT = 'PREGNANT';
    case DISABILITY = 'DISABILITY';
    case CHILDREN_BABY = 'CHILDREN_BABY';

    public function label(): string
    {
        return match ($this) {
            self::NONE => 'Ninguna',
            self::SENIOR => 'Adulto Mayor',
            self::PREGNANT => 'Embarazada',
            self::DISABILITY => 'Discapacidad',
            self::CHILDREN_BABY => 'Niño/Bebé'
        };
    }

    // Orden de prioridad (para lógica de cola)
    public function weight(): int
    {
        return match ($this) {
            self::NONE => 0,
            self::SENIOR => 3,
            self::PREGNANT => 4,
            self::DISABILITY => 2,
            self::CHILDREN_BABY => 1
        };
    }

    public function getPriorityPrefix(): string
    {
        return match ($this) {
            self::NONE => 'T',
            self::SENIOR => 'P',
            self::PREGNANT => 'E',
            self::DISABILITY => 'D',
            self::CHILDREN_BABY => 'N',
            default => 'T'
        };
    }

    public static function getPriorityPrefixByValue(string $value): string
    {
        return match ($value) {
            self::NONE => '',
            self::SENIOR => 'P',
            self::PREGNANT => 'E',
            self::DISABILITY => 'D',
            self::CHILDREN_BABY => 'N',
            default => 'T'
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
