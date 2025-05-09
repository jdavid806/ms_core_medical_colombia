<?php

namespace App\Repositories;

use App\Models\PrescriptionDetail;

class PrescriptionDetailRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(PrescriptionDetail $prescriptionDetail)
    {
        parent::__construct($prescriptionDetail, self::RELATIONS);
    }
}
