<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specializable extends Model
{
    protected $fillable = [
        "specialty_id",
        "specializable_id",
        "specializable_type",
        "description"
    ];

    public function specializable()
    {
        return $this->morphTo();
    }
}
