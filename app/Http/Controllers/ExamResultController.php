<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamResult\StoreExamResultRequest;
use App\Http\Requests\ExamResult\UpdateExamResultRequest;
use App\Services\ExamResultService;

class ExamResultController extends Controller
{
    protected $service;
    protected $relations = ['examOrder.examType'];

    public function __construct(ExamResultService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->getAll()->load($this->relations);
    }

    public function show($id)
    {
        return $this->service->getById($id)->load($this->relations);
    }

    public function store(StoreExamResultRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateExamResultRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
