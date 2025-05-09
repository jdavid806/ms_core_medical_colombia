<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ClinicalRecord extends Model
{
    protected $table = 'clinical_records';
    protected $fillable = [
        'clinical_record_type_id',
        'created_by_user_id',
        'appointment_id',
        'patient_id',
        'branch_id',
        'description',
        'data',
        'consultation_duration',
        'is_active',
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
        'consultation_duration' => 'string',
    ];

    public function clinicalRecordType()
    {
        return $this->belongsTo(ClinicalRecordType::class);
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function evolutionNotes()
    {
        return $this->hasMany(ClinicalEvolutionNote::class);
    }

    public function remissions()
    {
        return $this->hasMany(Remission::class);
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    public function examRecipes(): HasMany
    {
        return $this->hasMany(ExamRecipe::class);
    }

    public function patientDisabilities() : HasMany
    {
        return $this->hasMany(PatientDisability::class);
    }

    public function vaccineApplications() : HasMany
    {
        return $this->hasMany(VaccineApplication::class);
    }

    public function specializables()
    {
        return $this->morphMany(Specializable::class, 'specializable');
    }

    public function aiResponses(): MorphMany
    {
        return $this->morphMany(AiResponse::class, 'responsable');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    
}
