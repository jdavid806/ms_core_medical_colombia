<?php

namespace App\Services;

use App\Repositories\PatientRepository;

class TenantService extends BaseService
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
}
