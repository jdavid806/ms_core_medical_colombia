<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientDisability\StorePatientDisabilityRequest;
use App\Http\Requests\PatientDisability\UpdatePatientDisabilityRequest;
use App\Services\PatientDisabilityService;

class PatientDisabilityController extends Controller
{
    protected $service;
    protected $relations = ['patient', 'user'];

    public function __construct(PatientDisabilityService $service)
    {
        $this->service = $service;
    }

    public function index($patientId)
    {
        return $this->service->ofParent($patientId)->load($this->relations);
    }

    public function show($id)
    {
        return $this->service->getById($id)->load($this->relations);
    }

    public function store(StorePatientDisabilityRequest $request, $patientId)
    {
        return $this->service->createForParent($patientId, $request->validated());
    }

    public function update(UpdatePatientDisabilityRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    public function getLastByPatient($patientId)
    {
        return $this->service->getLastByPatient($patientId)->load($this->relations);
    }
}
