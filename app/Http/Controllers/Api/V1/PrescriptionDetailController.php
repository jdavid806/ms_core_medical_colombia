<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\PrescriptionDetail;
use App\Http\Controllers\Controller;
use App\Services\PrescriptionDetailService;
use App\Http\Resources\Api\V1\PrescriptionDetail\PrescriptionDetailResource;
use App\Http\Requests\Api\V1\PrescriptionDetail\StorePrescriptionDetailRequest;
use App\Http\Requests\Api\V1\PrescriptionDetail\UpdatePrescriptionDetailRequest;

class PrescriptionDetailController extends Controller
{
    public function __construct(private PrescriptionDetailService $prescriptionDetailService) {}

    public function index()
    {
        $prescriptionDetails = $this->prescriptionDetailService->getAllPrescriptionDetails();
        return PrescriptionDetailResource::collection($prescriptionDetails);
    }

    public function store(StorePrescriptionDetailRequest $request)
    {
        $prescriptionDetail = $this->prescriptionDetailService->createPrescriptionDetail($request->validated());
        return response()->json([
            'message' => 'PrescriptionDetail created successfully',
            'PrescriptionDetail' => $prescriptionDetail,
        ]);
    }

    public function show(PrescriptionDetail $prescriptionDetail)
    {
        return new PrescriptionDetailResource($prescriptionDetail);
    }

    public function update(UpdatePrescriptionDetailRequest $request, PrescriptionDetail $prescriptionDetail)
    {
        $this->prescriptionDetailService->updatePrescriptionDetail($prescriptionDetail, $request->validated());
        return response()->json([
            'message' => 'PrescriptionDetail updated successfully',
        ]);
    }

    public function destroy(PrescriptionDetail $prescriptionDetail)
    {
        $this->prescriptionDetailService->deletePrescriptionDetail($prescriptionDetail);
        return response()->json([
            'message' => 'PrescriptionDetail deleted successfully',
        ]);
    }

    //
}
