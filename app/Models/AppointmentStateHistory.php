<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentStateHistory extends Model
{
    protected $table = 'appointment_state_history';
    protected $fillable = [
        'appointment_id',
        'appointment_state_id',
        'change_date',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function appointmentState()
    {
        return $this->belongsTo(AppointmentState::class);
    }
}
