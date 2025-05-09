<?php

namespace App\Helpers;

use UnitEnum;

class EnumHelper
{
    public static function toString(string $enumClass): string
    {
        if (!enum_exists($enumClass)) {
            throw new \InvalidArgumentException("La clase proporcionada no es un Enum válido.");
        }

        return implode(',', array_map(fn($case) => $case->value, $enumClass::cases()));
    }

    public static function fromString(string $enumClass, string $value): UnitEnum
    {
        $enum = $enumClass::tryFrom($value);

        if (!$enum) {
            throw new \InvalidArgumentException("El valor '{$value}' no es válido para el enum {$enumClass}.");
        }

        return $enum;
    }

    public static function toArray(string $enumClass): array
    {
        return array_map(fn($case) => $case->value, $enumClass::cases());
    }

    public static function options(string $enumClass): array
    {
        return collect($enumClass::cases())
            ->mapWithKeys(fn($case) => [
                $case->value => method_exists($case, 'label') ?
                    $case->label() :
                    $case->value
            ])
            ->toArray();
    }
}
