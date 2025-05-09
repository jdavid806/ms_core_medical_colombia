<?php

namespace App\Services;

use App\Repositories\UserSpecialtyMenuRepository;

class UserSpecialtyMenuService extends ManyToManyService
{
    protected $repository;

    public function __construct(UserSpecialtyMenuRepository $repository)
    {
        $this->repository = $repository;
    }
}
