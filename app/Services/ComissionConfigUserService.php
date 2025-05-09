<?php

namespace App\Services;

use App\Repositories\ComissionConfigUserRepository;

class ComissionConfigUserService extends OneToManyService
{
    protected $repository;

    public function __construct(ComissionConfigUserRepository $repository)
    {
        $this->repository = $repository;
    }
}
