<?php

namespace App\Repositories;

use App\Models\RecipeItemOptometry;

class RecipeItemOptometryRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(RecipeItemOptometry $recipeItemOptometry)
    {
        parent::__construct($recipeItemOptometry, self::RELATIONS);
    }
}
