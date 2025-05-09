<?php

namespace App\Models;

use App\Enum\TicketReason;
use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'patient_name',
        'phone',
        'email',
        'reason',
        'priority',
        'status',
        'branch_id',
        'module_id',
        'patient_id'
    ];

    protected $casts = [
        'reason' => TicketReason::class,
        'priority' => TicketPriority::class,
        'status' => TicketStatus::class,
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'patient_id', 'patient_id');
    }
}
