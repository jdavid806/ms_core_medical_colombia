<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\V1\ApiController;
use App\Services\ClinicalRecordService;
use App\Http\Requests\ClinicalRecord\StoreClinicalRecordParams;
use App\Http\Requests\ClinicalRecord\StoreClinicalRecordRequest;
use App\Http\Requests\ClinicalRecord\UpdateClinicalRecordRequest;
use App\Models\Appointment;

class ClinicalRecordController extends ApiController
{
    protected $service;
    protected $relations = ["clinicalRecordType", "patient", "createdByUser",  "evolutionNotes", "remissions", "recipes", "examRecipes", "patientDisabilities", "vaccineApplications"];

    public function __construct(ClinicalRecordService $service)
    {
        $this->service = $service;
    }

    public function index($patientId)
    {
        return $this->service->ofParent($patientId)->load($this->relations);
    }

    public function show($id)
    {
        $clinicalRecord = $this->service->getById($id);
        return $clinicalRecord->load($this->relations);
    }

    public function store(StoreClinicalRecordRequest $request, $patientId)
    {
        return $this->service->createForParent($patientId, $request->validated());
    }


    public function crateClinicalRecordParams(StoreClinicalRecordParams $request, $patientId)
    {
        $data = $request->validated();


        // Llama al servicio pasándole el paciente y los datos validados
        return $this->service->createClinicalRecord($patientId, $data);
    }


    public function update(UpdateClinicalRecordRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    public function getByType($type, $patientId)
    {
        return $this->service->getByType($type, $patientId)->load($this->relations);
    }

    public function getLastByPatient($patientId)
    {
        return $this->service->getLastByPatient($patientId)->load($this->relations);
    }

    public function getParaclinicalByAppointment(Appointment $appointment)
    {
        try {
            $result = optional($appointment->examRecipe)->result;

            return $this->success(
                $result ? 'Resultados encontrados' : 'No se encontraron resultados',
                $result
            );
        } catch (\Exception $e) {
            return $this->error('Error al obtener los resultados', 500);
        }
    }
}
