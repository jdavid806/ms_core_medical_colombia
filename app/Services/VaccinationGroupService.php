<?php

namespace App\Services;

use App\Repositories\VaccinationGroupRepository;

class VaccinationGroupService extends BaseService
{
    protected $repository;

    public function __construct(VaccinationGroupRepository $repository)
    {
        $this->repository = $repository;
    }
}
