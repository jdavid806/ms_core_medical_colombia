<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\EstimateService;
use Illuminate\Http\Request;

class EstimateServiceController extends Controller
{

    public function __construct(private EstimateService $estimateService) {}
    public function getAllEstimates()
    {
        $services = $this->estimateService->getEstimates();
        return response()->json($services);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $estimate = $this->estimateService->createEstimate($data);
        return response()->json($estimate);
    }
}
