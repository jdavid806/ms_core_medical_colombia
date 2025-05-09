<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'assigned_user_availability_id',
        'assigned_supervisor_user_availability_id',
        'created_by_user_id',
        'patient_id',
        'appointment_state_id',
        'appointment_time',
        'appointment_date',
        'attention_type',
        'consultation_purpose',
        'consultation_type',
        'external_cause',
        'is_active',
        'product_id',
        'supervisor_user_id',
        'exam_recipe_id',
    ];

    //dame un json para crear una cita basado en estos campos

    protected $casts = [
        'is_active' => 'boolean'
    ];


    public function assignedUserAvailability(): BelongsTo
    {
        return $this->belongsTo(UserAvailability::class, 'assigned_user_availability_id');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function examRecipe(): BelongsTo
    {
        return $this->belongsTo(ExamRecipe::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function appointmentState(): BelongsTo
    {
        return $this->belongsTo(AppointmentState::class);
    }

    public function userAvailability(): BelongsTo
    {
        return $this->belongsTo(UserAvailability::class, 'assigned_user_availability_id');
    }

    public function supervisorUserAvailability(): BelongsTo
    {
        return $this->belongsTo(UserAvailability::class, 'assigned_supervisor_user_availability_id');
    }

    public function supervisorUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_user_id');
    }

    public function clinicalRecords(): BelongsTo
    {
        return $this->belongsTo(ClinicalRecord::class);
    }

    public function examOrders(): HasMany
    {
        return $this->hasMany(ExamOrder::class);
    }

    public function surveyResponse(): HasOne
    {
        return $this->hasOne(Survey::class);
    }



    public function getConsultationPurposeAttribute()
    {
        $consultationsPurpose = $this->attributes['consultation_purpose'];

        switch ($consultationsPurpose) {
            case 'PROMOTION':
                $consultationsPurpose = 'Promoción';
                break;
            case 'PREVENTION':
                $consultationsPurpose = 'Prevención';
                break;
            case 'TREATMENT':
                $consultationsPurpose = 'Tratamiento';
                break;
            case 'REHABILITATION':
                $consultationsPurpose = 'Rehabilitación';
                break;
        }

        return $consultationsPurpose;
    }


    public function getConsultationTypeAttribute()
    {
        $consultationType = $this->attributes['consultation_type'];

        switch ($consultationType) {
            case 'CONTROL':
                $consultationType = 'Promoción';
                break;
            case 'EMERGENCY':
                $consultationType = 'Emergencia';
                break;
            case 'FIRST_TIME':
                $consultationType = 'Primera vez';
                break;
            case 'FOLLOW_UP':
                $consultationType = 'Seguimiento';
                break;
        }

        return $consultationType;
    }

    public function getExternalCauseAttribute()
    {
        $externalCause = $this->attributes['external_cause'];

        switch ($externalCause) {
            case 'ACCIDENT':
                $externalCause = 'Accidente';
                break;
            case 'OTHER':
                $externalCause = 'Otro';
                break;
            case 'NOT_APPLICABLE':
                $externalCause = 'No aplica';
                break;
        }

        return $externalCause;
    }

    protected $appends = ['original_state']; // Solo si necesitas acceder al valor original desde otras partes

    public function getOriginalStateAttribute()
    {
        return $this->getOriginal('appointment_state_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'patient_id', 'patient_id');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder
    {
        return $filters->apply($builder);
    }
}
