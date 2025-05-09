<?php

namespace App\Enum;

enum TicketReason: string
{
    case ADMISSION_PRESCHEDULED = 'ADMISSION_PRESCHEDULED';
    case CONSULTATION_GENERAL = 'CONSULTATION_GENERAL';
    case SPECIALIST = 'SPECIALIST';
    case VACCINATION = 'VACCINATION';
    case LABORATORY = 'LABORATORY';
    case EXIT_CONSULTATION = 'EXIT_CONSULTATION';
    case OTHER = 'OTHER';

    public function label(): string
    {
        return match ($this) {
            self::ADMISSION_PRESCHEDULED => 'Admisión (Cita Programada)',
            self::CONSULTATION_GENERAL => 'Consulta General',
            self::SPECIALIST => 'Especialista',
            self::VACCINATION => 'Vacunación',
            self::LABORATORY => 'Laboratorio',
            self::OTHER => 'Otro',
            self::EXIT_CONSULTATION => 'Salida de consulta'
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
