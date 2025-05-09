<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VaccineApplication extends Model
{
    protected $fillable = [
        'patient_id',
        'group_vaccine_id',
        'applied_by_user_id',
        'dose_number',
        'is_booster',
        'description',
        'application_date',
        'next_application_date',
        'is_active',
        'clinical_record_id',
    ];

    public function patient() : BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function groupVaccine() : BelongsTo
    {
        return $this->belongsTo(GroupVaccine::class);
    }

    public function appliedByUser() : BelongsTo
    {
        return $this->belongsTo(User::class, 'applied_by_user_id');
    }

    public function clinicalRecord() : BelongsTo
    {
        return $this->belongsTo(ClinicalRecord::class);
    }
}
