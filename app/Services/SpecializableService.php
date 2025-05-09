<?php

namespace App\Services;

use App\Repositories\SpecializableRepository;

class SpecializableService extends BaseService
{
    protected $repository;

    public function __construct(SpecializableRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getBySpecialty($specialtyId)
    {
        return $this->repository->getBySpecialty($specialtyId);
    }
}
