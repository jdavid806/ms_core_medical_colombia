<?php

namespace App\Repositories;

use App\Models\ExamCategory;

class ExamCategoryRepository extends BaseRepository
{
    protected $model;

    public function __construct(ExamCategory $model)
    {
        $this->model = $model;
    }

    public function getExamTypes($categoryId)
    {
        return $this->model->findOrFail($categoryId)->examTypes;
    }
}
