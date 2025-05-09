<?php

namespace App\Http\Controllers;

use App\Http\Requests\Branch\StoreBranchRequest;
use App\Http\Requests\Branch\UpdateBranchRequest;
use App\Services\BranchService;

class BranchController extends Controller
{
    protected $service;
    protected $relations = [];

    public function __construct(BranchService $service)
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

    public function store(StoreBranchRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateBranchRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
