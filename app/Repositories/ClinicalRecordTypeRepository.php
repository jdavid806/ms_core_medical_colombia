<?php

namespace App\Repositories;

use App\Models\ClinicalRecordType;

class ClinicalRecordTypeRepository extends BaseRepository
{
    protected $model;

    public function __construct(ClinicalRecordType $model)
    {
        $this->model = $model;
    }
}
