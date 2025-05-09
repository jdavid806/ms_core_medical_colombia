<?php

namespace App\Http\Controllers;

use App\Http\Requests\NursingNote\StoreNursingNoteRequest;
use App\Http\Requests\NursingNote\UpdateNursingNoteRequest;
use App\Services\NursingNoteService;

class NursingNoteController extends Controller
{
    protected $service;
    protected $relations = ['patient', 'user'];

    public function __construct(NursingNoteService $service)
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

    public function store(StoreNursingNoteRequest $request, $patientId)
    {
        return $this->service->createForParent($patientId, $request->validated());
    }

    public function update(UpdateNursingNoteRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
