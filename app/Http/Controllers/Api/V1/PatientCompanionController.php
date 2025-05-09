<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\PatientCompanion;
use App\Http\Controllers\Controller;
use App\Services\PatientCompanionService;
use App\Http\Resources\Api\V1\PatientCompanion\PatientCompanionResource;
use App\Http\Requests\Api\V1\PatientCompanion\StorePatientCompanionRequest;
use App\Http\Requests\Api\V1\PatientCompanion\UpdatePatientCompanionRequest;

class PatientCompanionController extends Controller
{
    public function __construct(private PatientCompanionService $patientCompanionService) {}

    public function index()
    {
        $patientCompanions = $this->patientCompanionService->getAllPatientCompanions();
        return PatientCompanionResource::collection($patientCompanions);
    }

    public function store(StorePatientCompanionRequest $request, Patient $patient)
    {
        $companions = $this->patientCompanionService->createPatientCompanions($request->companions, $patient);

        return response()->json([
            'message' => 'Acompañantes relacionados exitosamente.',
            'patient' => $patient,
            'companions' => $companions,
        ], 201);
    }

    public function show(PatientCompanion $patientCompanion)
    {
        return new PatientCompanionResource($patientCompanion);
    }

    public function update(UpdatePatientCompanionRequest $request, PatientCompanion $patientCompanion)
    {
        $this->patientCompanionService->updatePatientCompanions($patientCompanion, $request->validated());
        return response()->json([
            'message' => 'PatientCompanion updated successfully',
        ]);
    }

    public function destroy(PatientCompanion $patientCompanion)
    {
        $this->patientCompanionService->deletePatientCompanions($patientCompanion);
        return response()->json([
            'message' => 'PatientCompanion deleted successfully',
        ]);
    }

    //
}
