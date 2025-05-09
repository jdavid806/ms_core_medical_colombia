<?php

namespace App\Models;

use App\Filters\QueryFilter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConversationalFunnel extends ModelBase
{
    protected $table = 'conversational_funnels';

    protected $fillable = [
        'patient_id',
        'appointment_id',
        'channel',
        'current_agent_id',
        'status',
        'last_message',
        'last_event',
        'data_json',
    ];

    protected $casts = [
        'data_json' => 'array',
        'last_event' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}