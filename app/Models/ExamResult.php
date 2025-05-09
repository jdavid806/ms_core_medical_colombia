<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    protected $table = 'exam_results';

    protected $fillable = [
        'exam_order_id',
        'created_by_user_id',
        'results',
        'resource_url',
        'is_active',
    ];

    protected $casts = [
        'results' => 'array',
    ];

    public function examOrder()
    {
        return $this->belongsTo(ExamOrder::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
