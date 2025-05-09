<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Integration extends ModelBase
{
    protected $table = 'integrations';
    protected $fillable = [
        'name',
        'type',
        'status',
        'url',
        'auth_type',
        'auth_config',
    ];
    protected $casts = [
        'auth_config' => 'array',
    ];

    public function credentials(): HasMany
    {
        return $this->hasMany(IntegrationCredential::class);
    }   

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'integration_user');
    }
}