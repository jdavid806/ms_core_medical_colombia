<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Relationship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\RelationshipService;
use App\Http\Resources\Api\V1\Relationship\RelationshipResource;
use App\Http\Requests\Api\V1\Relationship\StoreRelationshipRequest;
use App\Http\Requests\Api\V1\Relationship\UpdateRelationshipRequest;

class RelationshipController extends Controller
{
    public function __construct(private RelationshipService $relationshipService) {}

    public function index()
    {
        $relationships = $this->relationshipService->getAllRelationships();
        return RelationshipResource::collection($relationships);
    }

    public function store(StoreRelationshipRequest $request)
    {
        $relationship = $this->relationshipService->createRelationship($request->validated());
        return response()->json([
            'message' => 'Relationship created successfully',
            'Relationship' => $relationship,
        ]);
    }

    public function show(Relationship $relationship)
    {
        return new RelationshipResource($relationship);
    }

    public function update(UpdateRelationshipRequest $request, Relationship $relationship)
    {
        $this->relationshipService->updateRelationship($relationship, $request->validated());
        return response()->json([
            'message' => 'Relationship updated successfully',
        ]);
    }

    public function destroy(Relationship $relationship)
    {
        $this->relationshipService->deleteRelationship($relationship);
        return response()->json([
            'message' => 'Relationship deleted successfully',
        ]);
    }

    //
}
