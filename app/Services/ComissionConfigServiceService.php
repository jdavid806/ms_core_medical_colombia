<?php

namespace App\Services;

use App\Repositories\ComissionConfigServiceRepository;

class ComissionConfigServiceService extends OneToManyService
{
    protected $repository;

    public function __construct(ComissionConfigServiceRepository $repository)
    {
        $this->repository = $repository;
    }
}
