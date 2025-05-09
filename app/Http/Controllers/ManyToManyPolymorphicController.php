<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManyToManyPolymorphicRequest;
use App\Interfaces\ManyToManyPolymorphicServiceInterface;

class ManyToManyPolymorphicController extends Controller
{
    protected $service;

    public function __construct(ManyToManyPolymorphicServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index($parentId)
    {
        return $this->service->ofParent($parentId);
    }

    public function indexByChildType($parentId, string $childType)
    {
        return $this->service->ofParentByChildType($parentId, $childType);
    }

    public function store(ManyToManyPolymorphicRequest $request, $parentId)
    {
        $this->service->createForParent($parentId, $request->children);
        return response()->noContent();
    }

    public function update(ManyToManyPolymorphicRequest $request, $parentId)
    {
        $this->service->updateForParent($parentId, $request->children);
        return response()->noContent();
    }

    public function destroy(ManyToManyPolymorphicRequest $request, $parentId)
    {
        $this->service->deleteForParent($parentId, $request->children);
        return response()->noContent();
    }
}
