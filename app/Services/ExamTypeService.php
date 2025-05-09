<?php

namespace App\Services;

use App\Repositories\ExamTypeRepository;

class ExamTypeService extends BaseService
{
    protected $repository;

    public function __construct(ExamTypeRepository $repository)
    {
        $this->repository = $repository;
    }
}
