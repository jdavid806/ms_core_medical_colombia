<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClinicalEvolutionNote\StoreClinicalEvolutionNoteRequest;
use App\Http\Requests\ClinicalEvolutionNote\UpdateClinicalEvolutionNoteRequest;
use App\Services\ClinicalEvolutionNoteService;

class ClinicalEvolutionNoteController extends Controller
{
    protected $service;
    protected $relations = [
        "clinicalRecord",
        "clinicalRecord.clinicalRecordType",
        "createdByUser"
    ];

    public function __construct(ClinicalEvolutionNoteService $service)
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

    public function getEvolutionsByParams($startDate, $endDate, $userId, $patientId)
    {
        return $this->service->getEvolutionByParams($startDate, $endDate, $userId, $patientId)->load($this->relations);
    }

    public function store(StoreClinicalEvolutionNoteRequest $request, $patientId)
    {
        return $this->service->createForParent($patientId, $request->validated());
    }

    public function update(UpdateClinicalEvolutionNoteRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
