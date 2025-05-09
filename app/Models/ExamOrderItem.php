<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamOrderItem extends Model
{
    protected $fillable = [
        'exam_order_id',
        'exam_type_id',
    ];

    public function exam()
    {
        return $this->belongsTo(ExamType::class, 'exam_type_id');
    }
}
