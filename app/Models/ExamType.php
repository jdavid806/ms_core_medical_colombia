<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'form_config',
        'type',
        'is_active',
    ];

    protected $casts = [
        'form_config' => 'array',
    ];
}
