<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentReason extends Model
{
    protected $fillable = ['name', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
