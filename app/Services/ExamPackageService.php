<?php

namespace App\Services;

use App\Repositories\ExamPackageRepository;

class ExamPackageService extends BaseService
{
    protected $repository;

    public function __construct(ExamPackageRepository $repository)
    {
        $this->repository = $repository;
    }
}
