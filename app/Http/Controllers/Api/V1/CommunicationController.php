<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Communication;
use App\Http\Controllers\Controller;
use App\Services\CommunicationService;
use App\Http\Resources\Api\V1\Communication\CommunicationResource;
use App\Http\Requests\Api\V1\Communication\StoreCommunicationRequest;
use App\Http\Requests\Api\V1\Communication\UpdateCommunicationRequest;

class CommunicationController extends Controller
{
    public function __construct(private CommunicationService $communicationService) {}

    public function index()
    {
        $communications = $this->communicationService->getAllCommunications();
        return CommunicationResource::collection($communications);
    }

    public function store(Request $request, Company $company)
    {
        if ($company->communication) {
            return response()->json([
                'message' => 'This company already has a communication configuration',
            ], 400);
        }

        $validatedData = $request->validate([
            'smtp_server' => 'required|string|max:255',
            'port' => 'required|integer',
            'security' => 'nullable|string',
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
            'api_key' => 'nullable|string|max:255',
            'instance' => 'nullable|string|max:255',
        ]);

        $validatedData['company_id'] = $company->id;

        $communication = Communication::create($validatedData);

        return response()->json([
            'message' => 'Communication configuration created successfully',
            'communication' => $communication,
        ], 201);
    }


    public function show(Company $company)
    {
        $communication = $company->communication;
    
        if (!$communication) {
            return response()->json([
                'message' => 'This company does not have a communication configuration',
            ], 404);
        }
    
        return response()->json($communication);
    }
    

    public function update(Request $request, Company $company)
    {
        $communication = $company->communication;

        if (!$communication) {
            return response()->json([
                'message' => 'This company does not have a communication configuration',
            ], 404);
        }

        $validatedData = $request->validate([
            'smtp_server' => 'string|max:255',
            'port' => 'integer',
            'security' => 'nullable|string',
            'email' => 'email|max:255',
            'password' => 'string|max:255',
            'api_key' => 'nullable|string|max:255',
            'instance' => 'nullable|string|max:255',
        ]);

        $communication->update($validatedData);

        return response()->json([
            'message' => 'Communication configuration updated successfully',
            'communication' => $communication,
        ]);
    }


    public function destroy(Company $company)
    {
        $communication = $company->communication;

        if (!$communication) {
            return response()->json([
                'message' => 'This company does not have a communication configuration',
            ], 404);
        }

        $communication->delete();

        return response()->json([
            'message' => 'Communication configuration deleted successfully',
        ]);
    }
}
