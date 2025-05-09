<?php

namespace App\Enum;

enum FrequencyEnum: string
{
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case BIMONTHLY = 'bimonthly';
    case SEMIANNUAL = 'semiannual';

    public function addToDate(\Carbon\Carbon $date): \Carbon\Carbon
    {
        return match ($this) {
            self::DAILY => $date->addDay(),
            self::WEEKLY => $date->addWeek(),
            self::MONTHLY => $date->addMonth(),
            self::BIMONTHLY => $date->addMonths(2),
            self::SEMIANNUAL => $date->addMonths(6),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
