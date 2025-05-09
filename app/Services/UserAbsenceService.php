<?php

namespace App\Services;

use App\Repositories\UserAbsenceRepository;

class UserAbsenceService extends OneToManyService
{
    protected $repository;

    public function __construct(UserAbsenceRepository $repository)
    {
        $this->repository = $repository;
    }
}
