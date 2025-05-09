<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamPackage extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    public function examTypes()
    {
        return $this->morphedByMany(ExamType::class, 'exam_package_item');
    }

    public function examCategories()
    {
        return $this->morphedByMany(ExamCategory::class, 'exam_package_item');
    }
}
