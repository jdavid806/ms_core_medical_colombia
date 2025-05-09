<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Entity;
use Illuminate\Http\Request;
use App\Services\EntityService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Entity\EntityResource;
use App\Http\Requests\Api\V1\Entity\StoreEntityRequest;
use App\Http\Requests\Api\V1\Entity\UpdateEntityRequest;


class EntityController extends Controller
{
    public function __construct(private EntityService $entityService) {}

    public function index()
    {
        $entitys = $this->entityService->getAllEntitys();
        return EntityResource::collection($entitys->load(['socialSecurities']));
    }

    public function store(StoreEntityRequest $request)
    {
        $entity = $this->entityService->createEntity($request->validated());
        return response()->json([
            'message' => 'Entity created successfully',
            'Entity' => $entity,
        ]);
    }

    public function show($id)
    {
        $entity = $this->entityService->getEntityById($id);
        return $entity;
    }

    public function update(UpdateEntityRequest $request, Entity $entity)
    {

        $this->entityService->updateEntity($entity, $request->validated());
        return response()->json([
            'message' => 'Entity updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $entity = $this->entityService->getEntityById($id);

        $this->entityService->deleteEntity($entity);
        return response()->json([
            'message' => 'Entity deleted successfully',
        ]);
    }

    //
}
