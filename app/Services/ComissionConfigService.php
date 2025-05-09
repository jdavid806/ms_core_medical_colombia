<?php

namespace App\Services;

use App\Repositories\ComissionConfigRepository;

class ComissionConfigService extends OneToManyService
{
    public $repository;

    public function __construct(ComissionConfigRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getComissions()
    {
        return $this->repository->getComissions();
    }

    public function getComissionById($id)
    {
        return $this->repository->getComissionById($id);
    }
}
