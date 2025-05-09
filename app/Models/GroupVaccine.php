<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupVaccine extends Model
{
    protected $fillable = ['vaccination_group_id', 'vaccine_id', 'is_active'];

    public function vaccinationGroup()
    {
        return $this->belongsToMany(VaccinationGroup::class, 'group_vaccines');
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }
}
