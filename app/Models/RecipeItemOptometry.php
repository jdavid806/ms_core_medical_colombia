<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeItemOptometry extends ModelBase
{
    protected $table = 'recipe_item_optometries';

    protected $fillable = [
        'recipe_id',
        'details',
    ];


    protected $casts = [
        'details' => 'array',
    ];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
