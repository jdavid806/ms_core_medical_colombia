<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRecipeResult\StoreExamRecipeResultRequest;
use App\Http\Requests\ExamRecipeResult\UpdateExamRecipeResultRequest;
use App\Services\ExamRecipeResultService;

class ExamRecipeResultController extends Controller
{
    protected $service;
    protected $relations = ['examRecipe.patient', 'examRecipe.user', 'examRecipe.details'];

    public function __construct(ExamRecipeResultService $service)
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

    public function store(StoreExamRecipeResultRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateExamRecipeResultRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
