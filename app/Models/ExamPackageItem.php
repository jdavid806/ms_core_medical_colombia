<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamPackageItem extends Model
{
    protected $fillable = [
        'exam_packages_id',
        'item_id',
        'item_type',
    ];

    public function examPackage()
    {
        return $this->belongsTo(ExamPackage::class);
    }

    public function item()
    {
        return $this->morphTo();
    }
}
