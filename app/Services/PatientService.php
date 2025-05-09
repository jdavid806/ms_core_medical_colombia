<?php

namespace App\Services;

use App\Repositories\PatientRepository;

class PatientService extends BaseService
{
    protected $repository;

    public function __construct(PatientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function evolution($id)
    {
        return $this->repository->evolution($id);
    }

    public function getByPhone($phone)
    {
        return $this->repository->getByPhone($phone);
    }

    public function getByDocument($document)
    {
        return $this->repository->getByDocument($document);
    }
}
