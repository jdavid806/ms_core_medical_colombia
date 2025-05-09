<?php

namespace App\Repositories;

use App\Models\ExamRecipeResult;

class ExamRecipeResultRepository extends BaseRepository
{
    protected $model;

    public function __construct(ExamRecipeResult $model)
    {
        $this->model = $model;
    }
}
