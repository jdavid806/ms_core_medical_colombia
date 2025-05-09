<?php

namespace App\Services;

use App\Repositories\UserRoleMenuRepository;

class UserRoleMenuService extends ManyToManyService
{
    protected $repository;

    public function __construct(UserRoleMenuRepository $repository)
    {
        $this->repository = $repository;
    }
}
