<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Companion;
use Illuminate\Http\Request;
use App\Services\CompanionService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Companion\CompanionResource;
use App\Http\Requests\Api\V1\Companion\StoreCompanionRequest;
use App\Http\Requests\Api\V1\Companion\UpdateCompanionRequest;

class CompanionController extends Controller
{
    public function __construct(private CompanionService $companionService) {}

    public function index()
    {
        $companions = $this->companionService->getAllCompanions(1);
        return CompanionResource::collection($companions);
    }

    public function store(StoreCompanionRequest $request)
    {
        $companion = $this->companionService->createCompanion($request->validated());
        return response()->json([
            'message' => 'Companion created successfully',
            'Companion' => $companion,
        ]);
    }

    public function show(Companion $companion)
    {
        return new CompanionResource($companion);
    }

    /* public function update(UpdateCompanionRequest $request, Companion $companion)
    {
        $this->companionService->updateCompanion($companion, $request->validated());
        return response()->json([
            'message' => 'Companion updated successfully',
        ]);
    }

    public function destroy(Companion $companion)
    {
        $this->companionService->deleteCompanion($companion);
        return response()->json([
            'message' => 'Companion deleted successfully',
        ]);
    } */

    //
}
