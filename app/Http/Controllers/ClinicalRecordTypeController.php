<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClinicalRecordType\StoreClinicalRecordTypeRequest;
use App\Http\Requests\ClinicalRecordType\UpdateClinicalRecordTypeRequest;
use App\Services\ClinicalRecordTypeService;

class ClinicalRecordTypeController extends Controller
{
    protected $service;

    public function __construct(ClinicalRecordTypeService $service)
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

    public function store(StoreClinicalRecordTypeRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateClinicalRecordTypeRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
