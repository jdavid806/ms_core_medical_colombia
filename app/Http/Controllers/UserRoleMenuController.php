<?php

namespace App\Http\Controllers;

use App\Services\UserRoleMenuService;

class UserRoleMenuController extends ManyToManyController
{
    protected $service;

    public function __construct(UserRoleMenuService $service)
    {
        $this->service = $service;
    }
}
