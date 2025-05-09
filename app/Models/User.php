<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends ModelBase
{
    use HasFactory, Notifiable;

    protected $connection = 'tenant';

    protected $fillable = [
        'external_id',
        'user_role_id',
        'user_specialty_id',
        'is_active',
        'first_name',
        'last_name',
        'middle_name',
        'second_last_name',
        'gender',
        'email',
        'phone',
        'address',
        'country_id',
        'city_id',
        'minio_id',
        'firma_minio_id',
        'image_minio_id',
        'clinical_record',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'external_id' => 'string'
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'user_role_id', 'id');
    }


    public function specialty(): BelongsTo
    {
        return $this->belongsTo(UserSpecialty::class, 'user_specialty_id', 'id');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function commissions()
    {
        return $this->hasMany(ComissionConfig::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(UserAvailability::class);
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'user_branch');
    }

    public function absences()
    {
        return $this->hasMany(UserAbsence::class);
    }

    public function assistants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_assistants', 'supervisor_user_id', 'assistant_user_id');
    }

    public function integrations(): BelongsToMany
    {
        return $this->belongsToMany(Integration::class, 'integration_users');
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name} {$this->second_last_name}");
    }

    /* Scopes */

    public function scopeIsDoctor($query)
    {
        return $query->whereHas('role', fn($q) => $q->where('group', 'DOCTOR'));
    }

    public function scopeIsAdmin($query)
    {
        return $query->whereHas('role', fn($q) => $q->where('group', 'ADMIN'));
    }

    public function isDoctor()
    {
        return $this->role->group === 'DOCTOR';
    }

    public function isAdmin()
    {
        return $this->role->group === 'ADMIN';
    }
}
