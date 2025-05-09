<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Representative;
use App\Http\Controllers\Controller;
use App\Services\RepresentativeService;
use App\Http\Resources\Api\V1\Representative\RepresentativeResource;
use App\Http\Requests\Api\V1\Representative\StoreRepresentativeRequest;
use App\Http\Requests\Api\V1\Representative\UpdateRepresentativeRequest;

class RepresentativeController extends Controller
{
    public function __construct(private RepresentativeService $representativeService) {}

    public function index()
    {
        $representatives = $this->representativeService->getAllRepresentatives();
        return RepresentativeResource::collection($representatives);
    }

    public function store(StoreRepresentativeRequest $request, Company $company)
    {
        if ($company->representative) {
            return response()->json([
                'message' => 'This company already has a representative',
            ], 400);
        }

        $data = $request->validated();
        $data['company_id'] = $company->id;

        $representative = Representative::create($data);

        return response()->json([
            'message' => 'Representative created successfully',
            'representative' => $representative,
        ], 201);
    }

    public function show(Company $company)
    {
        $representative = $company->representative;

        if (!$representative) {
            return response()->json([
                'message' => 'This company does not have a representative',
            ], 404);
        }

        return response()->json($representative);
    }

    public function update(Request $request, Company $company)
    {
        $representative = $company->representative;

        if (!$representative) {
            return response()->json([
                'message' => 'This company does not have a representative',
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'phone' => 'digits_between:7,15',
            'email' => 'email|max:255',
            'document_type' => 'string|in:ID,Passport,License',
            'document_number' => 'string|max:20|unique:representatives,document_number,' . $representative->id,
        ]);

        $representative->update($validatedData);

        return response()->json([
            'message' => 'Representative updated successfully',
            'representative' => $representative,
        ]);
    }

    public function destroy(Company $company)
    {
        $representative = $company->representative;

        if (!$representative) {
            return response()->json([
                'message' => 'This company does not have a representative',
            ], 404);
        }

        $representative->delete();

        return response()->json([
            'message' => 'Representative deleted successfully',
        ]);
    }

}
