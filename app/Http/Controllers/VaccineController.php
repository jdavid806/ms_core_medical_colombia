<?php

namespace App\Http\Controllers;

use App\Services\VaccineService;

class VaccineController extends Controller
{
    protected $service;

    public function __construct(VaccineService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->getAll();
    }

    public function show($id)
    {
        return $this->service->getById($id);
    }
}
