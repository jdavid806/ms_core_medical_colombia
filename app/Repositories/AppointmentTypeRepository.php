<?php

namespace App\Repositories;

use App\Models\AppointmentType;

class AppointmentTypeRepository extends BaseRepository
{
    protected $model;

    public function __construct(AppointmentType $model)
    {
        $this->model = $model;
    }
}
