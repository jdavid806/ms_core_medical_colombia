<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\BranchCompany;
use App\Http\Controllers\Controller;
use App\Models\BranchRepresentative;
use App\Services\BranchRepresentativeService;
use App\Http\Resources\Api\V1\BranchRepresentative\BranchRepresentativeResource;
use App\Http\Requests\Api\V1\BranchRepresentative\StoreBranchRepresentativeRequest;
use App\Http\Requests\Api\V1\BranchRepresentative\UpdateBranchRepresentativeRequest;

class BranchRepresentativeController extends Controller
{
    public function __construct(private BranchRepresentativeService $branchRepresentativeService) {}

    public function index()
    {
        $branchRepresentatives = $this->branchRepresentativeService->getAllBranchRepresentatives();
        return BranchRepresentativeResource::collection($branchRepresentatives);
    }

    public function store(Request $request, BranchCompany $branch)
    {
        if ($branch->representative) {
            return response()->json([
                'message' => 'This branch already has a representative',
            ], 400);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $validatedData['branch_company_id'] = $branch->id;

        $representative = BranchRepresentative::create($validatedData);

        return response()->json([
            'message' => 'Representative created successfully',
            'representative' => $representative,
        ], 201);
    }


    public function show(BranchCompany $branch)
    {
        $representative = $branch->representative;

        if (!$representative) {
            return response()->json([
                'message' => 'This branch does not have a representative',
            ], 404);
        }

        return response()->json($representative);
    }

    public function update(Request $request, BranchCompany $branch)
    {
        $representative = $branch->representative;

        if (!$representative) {
            return response()->json([
                'message' => 'This branch does not have a representative',
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'phone' => 'string|max:20',
        ]);

        $representative->update($validatedData);

        return response()->json([
            'message' => 'Representative updated successfully',
            'representative' => $representative,
        ]);
    }


    public function destroy(BranchCompany $branch)
    {
        $representative = $branch->representative;

        if (!$representative) {
            return response()->json([
                'message' => 'This branch does not have a representative',
            ], 404);
        }

        $representative->delete();

        return response()->json([
            'message' => 'Representative deleted successfully',
        ]);
    }
}
