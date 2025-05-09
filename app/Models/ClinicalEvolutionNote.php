<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicalEvolutionNote extends Model
{
    protected $fillable = [
        'clinical_record_id',
        'create_by_user_id',
        'note',
        'is_active',
    ];

    public function clinicalRecord()
    {
        return $this->belongsTo(ClinicalRecord::class);
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'create_by_user_id');
    }
}
