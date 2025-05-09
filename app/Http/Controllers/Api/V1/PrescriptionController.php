<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Services\PrescriptionService;
use App\Http\Resources\Api\V1\Prescription\PrescriptionResource;
use App\Http\Requests\Api\V1\Prescription\StorePrescriptionRequest;
use App\Http\Requests\Api\V1\Prescription\UpdatePrescriptionRequest;

class PrescriptionController extends Controller
{
    
    public function __construct(private PrescriptionService $prescriptionService) {}



    public function index()
    {
        $prescriptions = $this->prescriptionService->getAllPrescriptions();
        return PrescriptionResource::collection($prescriptions->load(['patient', 'prescriber', 'details']));
    }

    public function store(StorePrescriptionRequest $request)
    {

        $prescription = $this->prescriptionService->createPrescription($request->validated());

        return response()->json([
            'message' => 'Prescription created successfully',
            'Recipe' => $prescription,
        ]);
    }

    public function show(Prescription $prescription)
    {
        return new PrescriptionResource($prescription->load(['patient', 'prescriber', 'details']));
    }

    public function update(UpdatePrescriptionRequest $request, Prescription $prescription)
    {
        $this->prescriptionService->updatePrescription($prescription, $request->validated());
        return response()->json([
            'message' => 'Prescription updated successfully',
        ]);
    }

    public function destroy(Prescription $prescription)
    {
        $this->prescriptionService->deletePrescription($prescription);
        return response()->json([
            'message' => 'Prescription deleted successfully',
        ]);
    }

    //
}
