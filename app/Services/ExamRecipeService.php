<?php

namespace App\Services;

use App\Repositories\ExamRecipeRepository;

class ExamRecipeService
{

    public function __construct(private ExamRecipeRepository $examRecipeRepository){}

    public function createExamRecipe(array $data)
    {
        return $this->examRecipeRepository->create($data);
    }
}
