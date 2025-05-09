<?php

namespace App\Services;

use App\Repositories\ExamCategoryRepository;

class ExamCategoryService extends BaseService
{
    protected $repository;

    public function __construct(ExamCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getExamTypes($categoryId)
    {
        return $this->repository->getExamTypes($categoryId);
    }
}
