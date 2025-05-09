<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoryPreadmission\StoreHistoryPreadmissionRequest;
use App\Http\Requests\HistoryPreadmission\UpdateHistoryPreadmissionRequest;
use App\Services\HistoryPreadmissionService;

class HistoryPreadmissionController extends Controller
{
    protected $service;
    protected $relations = ['patient'];

    public function __construct(HistoryPreadmissionService $service)
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

    public function store(StoreHistoryPreadmissionRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateHistoryPreadmissionRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    public function historyByPatient($patientId, $isLast = 1)
    {
        $history = $this->service->historyByPatient($patientId, $isLast);

        if (!$history) {
            return response()->json(['message' => 'No se encontró historial para este paciente'], 404);
        }

        return response()->json($history->load($this->relations));
    }
}
