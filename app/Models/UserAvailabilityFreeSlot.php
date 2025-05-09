<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAvailabilityFreeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_availability_id',
        'start_time',
        'end_time',
    ];

    public function userAvailability()
    {
        return $this->belongsTo(UserAvailability::class);
    }
}
