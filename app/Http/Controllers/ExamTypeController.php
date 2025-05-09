<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamType\StoreExamTypeRequest;
use App\Http\Requests\ExamType\UpdateExamTypeRequest;
use App\Services\ExamTypeService;

class ExamTypeController extends Controller
{
    protected $service;

    public function __construct(ExamTypeService $service)
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

    public function store(StoreExamTypeRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateExamTypeRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
