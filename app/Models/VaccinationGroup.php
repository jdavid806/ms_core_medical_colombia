<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaccinationGroup extends Model
{
    protected $fillable = ['name', 'description', 'is_active'];

    public function groupVaccines()
    {
        return $this->belongsToMany(Vaccine::class, 'group_vaccines');
    }
}
