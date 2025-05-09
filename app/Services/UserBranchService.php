<?php

namespace App\Services;

use App\Repositories\UserBranchRepository;

class UserBranchService extends ManyToManyService
{
    protected $repository;

    public function __construct(UserBranchRepository $repository)
    {
        $this->repository = $repository;
    }
}
