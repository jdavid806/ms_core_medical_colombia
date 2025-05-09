<?php

namespace App\Services;

use App\Repositories\VaccineApplicationRepository;

class VaccineApplicationService extends OneToManyService
{
    protected $repository;

    public function __construct(VaccineApplicationRepository $repository)
    {
        $this->repository = $repository;
    }
}
