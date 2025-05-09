<?php

namespace App\Http\Controllers;

use App\Http\Requests\Module\StoreModuleRequest;
use App\Http\Requests\Module\UpdateModuleRequest;
use App\Services\ModuleService;

class ModuleController extends Controller
{
    protected $service;
    protected $relations = ['branch', 'tickets'];

    public function __construct(ModuleService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service
            ->getAll()
            ->load($this->relations);
    }

    public function show($id)
    {
        return $this->service
            ->getById($id)
            ->load($this->relations);
    }

    public function store(StoreModuleRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateModuleRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
