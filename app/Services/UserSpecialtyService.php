<?php

namespace App\Services;

use App\Models\UserSpecialty;
use App\Repositories\UserSpecialtyRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserSpecialtyService extends BaseService
{
    protected $repository;

    public function __construct(private UserSpecialtyRepository $userSpecialtyRepository, private SpecialtyService $specialtyService)
    {
        $this->repository = $userSpecialtyRepository;
    }


    public function createUserSpecialty(int $specialtyId)
    {
        $specialty = $this->specialtyService->getSpecialtyById($specialtyId);

        if (!$specialty) {
            throw new ModelNotFoundException("Especialidad no encontrada en la base de datos externa.");
        }

        if (UserSpecialty::where('name', $specialty->name)->exists()) {
            return response([
                'message' => 'Especialidad ya asignada'
            ]);
        }

        return $this->userSpecialtyRepository->create([
            'name' => $specialty->name,
            'is_active' => true,
        ]);
    }
}
