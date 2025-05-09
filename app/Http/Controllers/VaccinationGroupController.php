<?php

namespace App\Http\Controllers;

use App\Http\Requests\VaccinationGroup\StoreVaccinationGroupRequest;
use App\Http\Requests\VaccinationGroup\UpdateVaccinationGroupRequest;
use App\Services\VaccinationGroupService;

class VaccinationGroupController extends Controller
{
    protected $service;

    public function __construct(VaccinationGroupService $service)
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

    public function store(StoreVaccinationGroupRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateVaccinationGroupRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
