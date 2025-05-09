<?php

namespace App\Repositories;

use App\Models\ExamRecipe;

class ExamRecipeRepository extends BaseRepository
{
    const RELATIONS = ['details', 'patient', 'user'];

    public function __construct(ExamRecipe $examRecipe)
    {
        parent::__construct($examRecipe, self::RELATIONS);
    }
}
