<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeItem extends Model
{
    protected $fillable = [
        'recipe_id',
        'medication',
        'concentration',
        'frequency',
        'duration',
        'medication_type',
        'take_every_hours',
        'quantity',
        'observations',
    ];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
