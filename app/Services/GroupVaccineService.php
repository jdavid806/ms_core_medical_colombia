<?php

namespace App\Services;

use App\Repositories\GroupVaccineRepository;

class GroupVaccineService extends ManyToManyService
{
    protected $repository;

    public function __construct(GroupVaccineRepository $repository)
    {
        $this->repository = $repository;
    }
}
