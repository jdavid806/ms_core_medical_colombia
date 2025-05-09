<?php

namespace App\Http\Controllers;

use App\Http\Requests\VaccineApplication\StoreVaccineApplicationRequest;
use App\Http\Requests\VaccineApplication\UpdateVaccineApplicationRequest;
use App\Services\VaccineApplicationService;

class VaccineApplicationController extends Controller
{
    protected $service;

    public function __construct(VaccineApplicationService $service)
    {
        $this->service = $service;
    }

    public function index($patientId)
    {
        return $this->service->ofParent($patientId);
    }

    public function show($id)
    {
        return $this->service->getById($id);
    }

    public function store(StoreVaccineApplicationRequest $request, $patientId)
    {
        return $this->service->createForParent($patientId, $request->validated());
    }

    public function update(UpdateVaccineApplicationRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
