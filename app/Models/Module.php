<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'branch_id',
        'allowed_reasons',
        'last_assigned_at',
        'is_active'
    ];

    protected $casts = [
        'allowed_reasons' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Relación con la sucursal
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Relación con los tickets
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
