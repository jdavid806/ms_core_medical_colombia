<?php

namespace App\Enum;

enum RetentionValueEnum: string
{
    case Casado  = 'Casado';
    case Divorciado = 'Divorciado';
    case Soltero= 'Soltero';
    case Viudo = 'Viudo';
    case Otro = 'Otro';
    
    public function getLabel(): ?string
    {
        return $this->name;
        
   
        return match ($this) {
            self::Casado => 'Casado',
            self::Divorciado => 'Divorciado',
            self::Soltero => 'Soltero',
            self::Viudo => 'Viudo',
            self::Otro => 'Otro',
        };
    }
}