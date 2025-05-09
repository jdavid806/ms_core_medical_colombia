<?php

namespace App\Http\Controllers;

use App\Services\ComissionConfigServiceService;

class ComissionConfigServiceController extends BasicController
{
    protected $service;

    public function __construct(ComissionConfigServiceService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $this->service->getAll();
    }

    public function show($id)
    {
        return $this->service->getById($id);
    }

    public function store($request)
    {
        return $this->service->create($request);
    }

    public function update($request, $id)
    {
        return $this->service->update($id, $request);
    }
}
