<?php

namespace App\Enum;

enum TicketStatus: string
{
    case PENDING = 'PENDING';
    case CALLED = 'CALLED';
    case COMPLETED = 'COMPLETED';
    case MISSED = 'MISSED';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pendiente',
            self::CALLED => 'Llamado',
            self::COMPLETED => 'Completado',
            self::MISSED => 'No Asistió'
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
