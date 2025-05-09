<?php

namespace App\Enum;

enum EthnicityEnum: string
{
    case Indigena  = 'Indigena';
    case Caucásica = 'Caucásica';
    case Asiática = 'Asiática';
    case Mestiza = 'Mestiza';
    
    public function getLabel(): ?string
    {
        return match ($this) {
            self::Indigena => 'Indigena',
            self::Caucásica => 'Caucásica',
            self::Asiática => 'Asiática',
            self::Mestiza => 'Mestiza',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
