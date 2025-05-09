<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicalRecordType extends Model
{
    protected $fillable = [
        'key_',
        'name',
        'description',
        'form_config',
        'is_active',
    ];

    protected $casts = [
        'form_config' => 'array'
    ];

    public function clinicalRecords()
    {
        return $this->hasMany(ClinicalRecord::class);
    }
}
