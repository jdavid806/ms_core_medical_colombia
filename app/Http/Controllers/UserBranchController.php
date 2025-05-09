<?php

namespace App\Http\Controllers;

use App\Services\UserBranchService;

class UserBranchController extends ManyToManyController
{
    protected $service;

    public function __construct(UserBranchService $service)
    {
        $this->service = $service;
    }
}
