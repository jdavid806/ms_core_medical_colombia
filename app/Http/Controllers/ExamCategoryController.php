<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamCategory\StoreExamCategoryRequest;
use App\Http\Requests\ExamCategory\UpdateExamCategoryRequest;
use App\Services\ExamCategoryService;

class ExamCategoryController extends Controller
{
    protected $service;

    public function __construct(ExamCategoryService $service)
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

    public function store(StoreExamCategoryRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateExamCategoryRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
