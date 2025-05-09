<?php

namespace App\Services;

use App\Repositories\UserRolePermissionRepository;

class UserRolePermissionService extends ManyToManyService
{
    protected $repository;

    public function __construct(UserRolePermissionRepository $repository)
    {
        $this->repository = $repository;
    }
}
