<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    protected $fillable = ['department_id', 'name', 'area_code', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function departments(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
