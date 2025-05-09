<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $fillable = [
        'office_id', 'name', 'email', 'whatsapp', 'country_id', 'department_id', 'city_id', 'address', 'responsible_id', 'active'
    ];

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function responsible()
    {
        return $this->belongsTo(Person::class, 'responsible_id');
    }
}
