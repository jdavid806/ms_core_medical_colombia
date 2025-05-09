<?php

namespace App\Enum;

enum TypeRegimeEnum: string
{
    case Contributivo  = 'Contributivo';
    case Subsidiado = 'subsidiado';
    case Otro = 'Otro';
    
    public function getLabel(): ?string
    {
        return $this->name;
        
        return match ($this) {
            self::Contributivo => 'Contributivo',
            self::Subsidiado => 'Subsidiado',
            self::Otro => 'Otro'
        };
    }
}