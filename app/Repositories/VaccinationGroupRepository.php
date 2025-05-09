<?php

namespace App\Repositories;

use App\Models\VaccinationGroup;

class VaccinationGroupRepository extends BaseRepository
{
    protected $model;

    public function __construct(VaccinationGroup $model)
    {
        $this->model = $model;
    }
}
