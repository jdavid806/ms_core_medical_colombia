<?php

namespace App\Http\Controllers;

use App\Services\GroupVaccineService;

class GroupVaccineController extends ManyToManyController
{
    protected $service;

    public function __construct(GroupVaccineService $service)
    {
        $this->service = $service;
    }
}
