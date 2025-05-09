<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    protected $fillable = [
        'name',
        'availability_status',
        'expiration_status',
        'inventory_identifier',
        'is_active',
    ];

    public function groupVaccines()
    {
        return $this->hasMany(GroupVaccine::class);
    }
}
