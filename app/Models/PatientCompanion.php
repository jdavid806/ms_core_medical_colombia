<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientCompanion extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'relationship',
        'phone',
        'email',
        'is_active'
    ];
}
