<?php

namespace App\Repositories;

use App\Models\RecipeItem;

class RecipeItemRepository extends BaseRepository
{
    const RELATIONS = ['recipe'];

    public function __construct(RecipeItem $recipeItem)
    {
        parent::__construct($recipeItem, self::RELATIONS);
    }
}
