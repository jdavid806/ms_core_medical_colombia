<?php

namespace App\Http\Controllers;

use App\Services\UserRolePermissionService;

class UserRolePermissionController extends ManyToManyController
{
    protected $service;

    public function __construct(UserRolePermissionService $service)
    {
        $this->service = $service;
    }
}
