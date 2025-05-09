<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamRecipeResult extends Model
{
    protected $fillable = [
        'exam_recipe_id',
        'uploaded_by_user_id',
        'result_minio_id',
        'date',
        'comment',
    ];

    public function examRecipe()
    {
        return $this->belongsTo(ExamRecipe::class);
    }
}
