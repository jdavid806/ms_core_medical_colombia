<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserAvailability extends Model
{
    protected $fillable = [
        'user_id',
        'appointment_type_id',
        'branch_id',
        'appointment_duration',
        'days_of_week',
        'start_time',
        'end_time',
        'office',
        'module_id',
        'is_active',
    ];

    protected $casts = [
        'days_of_week' => 'array',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointmentType()
    {
        return $this->belongsTo(AppointmentType::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function freeSlots()
    {
        return $this->hasMany(UserAvailabilityFreeSlot::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function scopeActive($query)
    {
        return $query->whereRaw("is_active = true");
    }

    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId); // Filtra por user_id
    }

    public function scopeOfAppointmentType($query, $appointmentTypeId)
    {
        return $query->where('appointment_type_id', $appointmentTypeId); // Filtra por appointment_type_id
    }

    public function scopeOfBranch($query, $branchId)
    {
        return $query->when($branchId, fn($q) => $q->where('branch_id', $branchId)); // Filtra condicionalmente por branch_id
    }

    public function scopeOfDayOfWeek($query, $date)
    {
        $dayOfWeek = Carbon::parse($date)->dayOfWeek; // Obtiene el número del día (0 = Domingo, 6 = Sábado)
        return $query->whereRaw("days_of_week::jsonb @> '?'", [$dayOfWeek]);
    }

    public function scopeAvailableAtTime($query, $appointmentTime, $duration)
    {
        $endTime = Carbon::parse($appointmentTime)->addMinutes($duration)->format('H:i:s'); // Calcula el tiempo de finalización
        return $query->where('start_time', '<=', $appointmentTime) // Filtra por start_time
            ->where('end_time', '>=', $endTime); // Filtra por end_time
    }
}
