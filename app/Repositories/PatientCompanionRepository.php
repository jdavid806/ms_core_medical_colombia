<?php

namespace App\Repositories;

use App\Models\PatientCompanion;

class PatientCompanionRepository extends BaseRepository
{
    protected $model;

    public function __construct(PatientCompanion $model)
    {
        $this->model = $model;
    }
}
