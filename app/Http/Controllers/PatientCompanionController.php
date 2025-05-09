<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Services\PatientCompanionService;
use App\Http\Requests\PatientCompanion\StorePatientCompanionRequest;
use App\Http\Requests\PatientCompanion\UpdatePatientCompanionRequest;

class PatientCompanionController extends Controller
{
    protected $service;

    public function __construct(PatientCompanionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->getAll();
    }

    public function show($id)
    {
        return $this->service->getById($id);
    }

    public function store(StorePatientCompanionRequest $request, Patient $patient)
    {
        /* foreach ($request->companions as $companionData) {
            $patient->companions()->attach($companionData['companion_id'], [
                'relationship_id' => $companionData['relationship_id']
            ]);
        }
        return response()->json([
            'message' => 'Acompañantes relacionados exitosamente.',
            'patient' => $patient,
            'companions' => $patient->companions,
        ], 201); */
        $this->service->createPatientCompanion($request->validated(), $patient);

        return response()->json([
            'message' => 'Acompañantes relacionados exitosamente.',
            'patient' => $patient,
            'companions' => $patient->companions,
        ], 201);
    }

    public function update(UpdatePatientCompanionRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
