<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManyToManyRequest;
use App\Interfaces\ManyToManyServiceInterface;

class ManyToManyController extends Controller
{
    protected $service;

    public function __construct(ManyToManyServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index($parentId)
    {
        return $this->service->ofParent($parentId);
    }

    public function store(ManyToManyRequest $request, $parentId)
    {
        return $this->service->createForParent($parentId, $request->children_ids);
    }

    public function update(ManyToManyRequest $request, $parentId)
    {
        return $this->service->updateForParent($parentId, $request->children_ids);
    }

    public function destroy(ManyToManyRequest $request, $parentId)
    {
        return $this->service->deleteForParent($parentId, $request->children_ids);
    }
}
