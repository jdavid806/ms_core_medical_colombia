<?php

namespace App\Services;

use App\Models\Patient;
use App\Enum\EthnicityEnum;
use App\Models\PatientCompanion;
use App\Repositories\PatientRepository;
use App\Repositories\PatientCompanionRepository;

class PatientCompanionService extends BaseService
{
    protected $repository;


    /* public function createPatientCompanion($data, $patient)
    {
        foreach ($data['companions'] as $companionData) {
            $patient->companions()->attach($companionData['companion_id'], [
                'relationship_id' => $companionData['relationship_id']
            ]);
        }
        return $this->repository->create($data);
    } */


    public function __construct(private PatientCompanionRepository $patientCompanionRepository, private PatientRepository $patientRepository) {}

    public function getAllPatientCompanions()
    {
        return $this->patientCompanionRepository->all();
    }

    public function getPatientCompanionsById(PatientCompanion $PatientCompanions, $patient)
    {

        return $this->patientCompanionRepository->find($PatientCompanions);
    }

    public function createPatientCompanions($patientData, $companions, $companionsData)
    {
        // Crear el paciente
        $patient = $this->patientRepository->create($patientData);

        // Relacionar los acompañantes con el paciente
        // Si $companions es un array de IDs (no objetos), deberías hacer:
        foreach ($companions as $key => $companionId) {
            if (isset($companionsData[$key]['relationship'])) {
                $patient->companions()->attach($companionId, [
                    'relationship' => $companionsData[$key]['relationship']
                ]);
            }
        }

        return $patient;
    }


    /* public function updatePatientCompanions(PatientCompanion $PatientCompanions, array $data)
    {
        return $this->patientCompanionRepository->update($PatientCompanions, $data);
    } */

    public function updatePatientCompanions(Patient $patient, array $data)
    {
        $patient->update($data);

        return $patient;
    }

    public function getPatientById($id)
    {
        return $this->patientRepository->find($id);
    }

    public function deletePatientCompanions(PatientCompanion $PatientCompanions)
    {
        return $this->patientCompanionRepository->delete($PatientCompanions);
    }
}
