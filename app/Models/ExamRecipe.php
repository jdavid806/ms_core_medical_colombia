<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamRecipe extends Model
{
    protected $fillable = [
        'patient_id',
        'user_id',
        'clinical_record_id',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(ExamRecipeDetail::class);
    }

    public function result()
    {
        return $this->hasOne(ExamRecipeResult::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
