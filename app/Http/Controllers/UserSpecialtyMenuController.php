<?php

namespace App\Http\Controllers;

use App\Services\UserSpecialtyMenuService;

class UserSpecialtyMenuController extends ManyToManyController
{
    protected $service;

    public function __construct(UserSpecialtyMenuService $service)
    {
        $this->service = $service;
    }
}
