<?php

namespace App\Http\Controllers;

use App\Http\Requests\Remission\StoreRemissionRequest;
use App\Http\Requests\Remmission\UpdateRemissionRequest;
use App\Services\RemissionService;

class RemissionController extends Controller
{
    protected $service;
    protected $relations = [
        "clinicalRecord",
        "clinicalRecord.clinicalRecordType",
        "receiverByUser",
        "remitterByUser"
    ];

    public function __construct(RemissionService $service)
    {
        $this->service = $service;
    }

    public function index($clinicalRecordId)
    {
        return $this->service->ofParent($clinicalRecordId)->load($this->relations);
    }

    public function show($id)
    {
        return $this->service->getById($id);
    }

    public function getRemissionsByParams($startDate, $endDate, $userId, $patientId)
    {
        return $this->service->getRemissionByParams($startDate, $endDate, $userId, $patientId)->load($this->relations);
    }

    public function store(StoreRemissionRequest $request, $clinicalRecordId)
    {
        return $this->service->createForParent($clinicalRecordId, $request->validated());
    }

    public function update(UpdateRemissionRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
