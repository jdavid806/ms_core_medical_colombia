<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'document_type', 'document_number', 'email', 'whatsapp', 'gender', 'birthdate', 'active'
    ];

    public function empresas(): HasMany
    {
        return $this->hasMany(Company::class, 'legal_representative_id');
    }

    public function sucursals(): HasMany
    {
        return $this->hasMany(Sucursal::class, 'responsible_id');
    }
}
