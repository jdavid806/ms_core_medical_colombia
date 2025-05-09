<?php

namespace App\Services;

use App\Repositories\PatientDisabilityRepository;

class PatientDisabilityService extends OneToManyService
{
    protected $repository;

    public function __construct(PatientDisabilityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getLastByPatient($patientId)
    {
        return $this->repository->getLastByPatient($patientId);
    }
}
