<?php

namespace App\Http\Controllers\Api\V2;


use App\Filters\PatientFilter;
use App\Http\Controllers\Controller;
use App\Services\V2\PatientServiceV2;
use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\Api\V2\Patient\PatientResourceV2;

class PatientControllerV2 extends ApiController
{
    public function __construct(private PatientServiceV2 $patientServiceV2) {}

    public function index($externalId = null)
    {
        $filters = request()->only(['name', 'identification', 'phone', 'appointment_status']);
        $patients = $this->patientServiceV2->getAllPatients($filters, $externalId);
        return response()->json($patients);
    }

    public function getPatientsWithAppointments($externalId = null)
    {
        $filters = request()->only(['name', 'identification', 'phone', 'appointment_status']);
        $patients = $this->patientServiceV2->getAllPatientsWithAppointments($filters, $externalId);
        return response()->json($patients);
    }

    public function getAllPatients(PatientFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        // Obtener las relaciones a incluir desde el parámetro 'include'
        $includes = $this->parseIncludes(request()->get('include'));

        $patients = $this->patientServiceV2->getPatients($filters, $perPage);

        // Cargar relaciones dinámicamente si se especifican
        if (!empty($includes)) {
            $patients->load($includes);
        }

        return $this->ok('Patients retrieved successfully', PatientResourceV2::collection($patients));
    }

    protected function parseIncludes(?string $includeParam): array
    {
        if (!$includeParam) {
            return [];
        }

        return array_map('trim', explode(',', $includeParam));
    }
}
