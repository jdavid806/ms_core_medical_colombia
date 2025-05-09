<?php

namespace App\Services;

use App\Repositories\BranchRepository;

class BranchService extends BaseService
{
    protected $repository;

    public function __construct(BranchRepository $repository)
    {
        $this->repository = $repository;
    }
}
