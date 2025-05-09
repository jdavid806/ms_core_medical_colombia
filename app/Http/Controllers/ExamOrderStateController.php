<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamOrderState\StoreExamOrderStateRequest;
use App\Http\Requests\ExamOrderState\UpdateExamOrderStateRequest;
use App\Services\ExamOrderStateService;

class ExamOrderStateController extends Controller
{
    protected $service;

    public function __construct(ExamOrderStateService $service)
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

    public function store(StoreExamOrderStateRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateExamOrderStateRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
