<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\Models\SocialSecurity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Patient extends Model
{
    protected $table = 'patients';
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'document_type',
        'document_number',
        'first_name',
        'middle_name',
        'last_name',
        'second_last_name',
        'gender',
        'date_of_birth',
        'whatsapp',
        'email',
        'civil_status',
        'ethnicity',
        'country_id',
        'department_id',
        'city_id',
        'address',
        'nationality',
        'social_security_id',
        'relationship',
        'is_active',
        'blood_type',
        'minio_id',

        'educational_level',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function disabilities()
    {
        return $this->hasMany(PatientDisability::class);
    }

    public function nursingNotes()
    {
        return $this->hasMany(NursingNote::class);
    }

    public function vaccineApplications(): HasMany
    {
        return $this->hasMany(VaccineApplication::class);
    }


    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function clinicalRecords(): HasMany
    {
        return $this->hasMany(ClinicalRecord::class);
    }


    public function companions(): BelongsToMany
    {
        return $this->belongsToMany(Companion::class, 'companion_patient')
            ->withPivot('relationship', 'status') // Campo adicional
            ->withTimestamps(); // Si la tabla intermedia tiene timestamps
    }

    public function socialSecurity(): BelongsTo
    {
        return $this->belongsTo(SocialSecurity::class);
    }

    public function exams(): HasManyThrough
    {
        return $this->hasManyThrough(
            ExamResult::class,
            ExamOrder::class,
            'patient_id',
            'exam_order_id',
            'id',
            'id'
        );
    }

    public function evolutionNotes(): HasManyThrough
    {
        return $this->hasManyThrough(
            ClinicalEvolutionNote::class,
            ClinicalRecord::class,
            'patient_id',
            'clinical_record_id',
            'id',
            'id'
        );
    }

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }


    public function examRecipes(): HasMany
    {
        return $this->hasMany(ExamRecipe::class);

    }

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }


    public function aiResponses(): MorphMany
    {
        return $this->morphMany(AiResponse::class, 'responsable');
    }


    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name} {$this->second_last_name}");
    }


    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder
    {
        return $filters->apply($builder);
    }
}
