<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamPackage\StoreExamPackageRequest;
use App\Http\Requests\ExamPackage\UpdateExamPackageRequest;
use App\Services\ExamPackageService;

class ExamPackageController extends Controller
{
    protected $service;

    public function __construct(ExamPackageService $service)
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

    public function store(StoreExamPackageRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateExamPackageRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
