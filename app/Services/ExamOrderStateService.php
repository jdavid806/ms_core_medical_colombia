<?php

namespace App\Services;

use App\Repositories\ExamOrderStateRepository;

class ExamOrderStateService extends BaseService
{
    protected $repository;

    public function __construct(ExamOrderStateRepository $repository)
    {
        $this->repository = $repository;
    }
}
