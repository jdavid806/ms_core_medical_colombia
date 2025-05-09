<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamCategory extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    public function examTypes()
    {
        return $this->hasMany(ExamType::class);
    }

    public function examPackages()
    {
        return $this->morphToMany(ExamPackage::class, 'item');
    }
}
