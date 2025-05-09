<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Patient;
use App\Models\Companion;
use App\Enum\EthnicityEnum;
use Illuminate\Http\Request;
use App\Models\SocialSecurity;
use App\Services\CompanionService;
use App\Http\Controllers\Controller;
use App\Services\SocialSecurityService;
use App\Services\PatientCompanionService;
use App\Http\Requests\Api\V1\PatientCompanionSocialSecurity\StorePatientCompanionSocialSecurityRequest;
use App\Http\Requests\Api\V1\PatientCompanionSocialSecurity\UpdatePatientCompanionSocialSecurityRequest;

class PatientCompanionSocialSecurityController extends Controller
{

    public function __construct(
        private PatientCompanionService $patientCompanionService,
        private CompanionService $companionService,
        private SocialSecurityService $socialSecurityService
    ) {}
    public function storePatient(StorePatientCompanionSocialSecurityRequest $request)
    {
        // Crear los acompañantes
        $companionsData = $request->input('companions');
        $companions = $this->companionService->createCompanions($companionsData);

        // Crear la seguridad social
        $socialSecurity = $this->socialSecurityService->createSocialSecurity($request->input('social_security'));

        // Crear el paciente y relacionarlo con los acompañantes
        $patientData = $request->input('patient');
        $patientData['ethnicity'] = $request->input('patient.ethnicity');
        $patientData['social_security_id'] = $socialSecurity->id;
        $patient = $this->patientCompanionService->createPatientCompanions($patientData, $companions, $companionsData);

        return response()->json([
            'message' => 'Paciente y seguridad social creados exitosamente, acompañantes relacionados con el paciente.',
            'patient_id' => $patient->id,
            'social_security_id' => $socialSecurity->id,
            'companions' => $patient->companions
        ], 201);
    }

    public function updatePatient(UpdatePatientCompanionSocialSecurityRequest $request, $id)
    {
        // Obtener el paciente existente
        $patient = $this->patientCompanionService->getPatientById($id);
        $patientData = $request->input('patient');

        // Actualizar la seguridad social
        $socialSecurityData = $request->input('social_security');

        if (!isset($patient->socialSecurity) || $patient->socialSecurity == null) {
            $updatedSocialSecurity = $this->socialSecurityService->createSocialSecurity($socialSecurityData);
            $patientData['social_security_id'] = $updatedSocialSecurity->id;
        } else {
            $updatedSocialSecurity = $this->socialSecurityService->updateSocialSecurity($patient->socialSecurity, $socialSecurityData);
        }

        // Actualizar los datos del paciente
        $patientData['ethnicity'] = $request->input('patient.ethnicity');
        $updatedPatient = $this->patientCompanionService->updatePatientCompanions($patient, $patientData);

        // Actualizar los acompañantes
        $companionsData = $request->input('companions');

        if (isset($companionsData)) {
            $this->companionService->updateCompanions($patient, $companionsData);
        }

        return response()->json([
            'message' => 'Paciente, seguridad social y acompañantes actualizados exitosamente.',
            'patient_id' => $updatedPatient->id,
            'social_security_id' => $updatedSocialSecurity->id,
            'companions' => $updatedPatient->companions
        ], 200);
    }
}
