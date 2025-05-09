<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Survey extends ModelBase
{
    protected $fillable = [
        'appointment_id',
        'respuesta',
        'status',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}