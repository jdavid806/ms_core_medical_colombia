<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamRecipeDetail extends Model
{
    protected $fillable = [
        'exam_recipe_id',
        'exam_type_id',
    ];

    public function examType()
    {
        return $this->belongsTo(ExamType::class);
    }
}
