<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Companion extends Model
{
    protected $fillable = [
        'document_type',
        'document_number',
        'first_name',
        'last_name',
        'mobile',
        'email',
        'is_active',
        'status',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'companion_patient')
                    ->withPivot('relationship', 'status') // Campo adicional
                    ->withTimestamps(); // Si la tabla intermedia tiene timestamps
    }
}
