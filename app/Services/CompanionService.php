<?php

namespace App\Services;

use App\Models\Patient;
use App\Repositories\CompanionRepository;

class CompanionService
{
    public function __construct(private CompanionRepository $companionRepository) {}


    public function getAllCompanions($patientId)
    {
        return $this->companionRepository->all($patientId);
    }


    public function createCompanions(array $data)
    {
        $companions = [];
        foreach ($data as $companionData) {
            $companions[] = $this->companionRepository->create($companionData);
        }
        return $companions;
    }



    public function createCompanion(array $data)
    {
        return $this->companionRepository->create($data);
    }

    public function updateCompanions(Patient $patient, array $companionsData)
    {
        // Eliminar relaciones existentes
        $patient->companions()->detach();
    
        // Crear nuevas relaciones
        foreach ($companionsData as $companionData) {
            if (!isset($companionData['companion_id'])) {
                // Crear un nuevo acompañante si no existe companion_id
                $companion = $this->companionRepository->create($companionData);
            } else {
                $companion = $this->companionRepository->find($companionData['companion_id']);
            }
    
            $patient->companions()->attach($companion->id, [
                'relationship' => $companionData['relationship']
            ]);
        }
    
        return $patient->companions;
    }
}
