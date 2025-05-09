<?php

namespace App\Repositories;

use App\Models\AdmissionType;

class AdmissionTypeRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(AdmissionType $admissiontype)
    {
        parent::__construct($admissiontype, self::RELATIONS);
    }
}
