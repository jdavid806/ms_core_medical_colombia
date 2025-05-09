<?php

namespace App\Http\Controllers;

use App\Services\AppointmentTypeService;

class AppointmentTypeController extends Controller
{
    protected $service;

    public function __construct(AppointmentTypeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->getAll();
    }
}
