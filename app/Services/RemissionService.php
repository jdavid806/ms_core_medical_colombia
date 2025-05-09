<?php

namespace App\Services;

use App\Repositories\RemissionRepository;

class RemissionService extends OneToManyService
{
    protected $repository;

    public function __construct(RemissionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getRemissionByParams($startDate, $endDate, $userId, $patientId)
    {
        return $this->repository->getRemissionByParams($startDate, $endDate, $userId, $patientId);
    }
}
