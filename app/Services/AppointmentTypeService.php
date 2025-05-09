<?php

namespace App\Services;

use App\Repositories\AppointmentTypeRepository;

class AppointmentTypeService extends BaseService
{
    protected $repository;

    public function __construct(AppointmentTypeRepository $repository)
    {
        $this->repository = $repository;
    }
}
