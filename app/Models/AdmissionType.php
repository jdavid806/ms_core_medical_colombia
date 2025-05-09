<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionType extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }
}
