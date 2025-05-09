<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'key',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
