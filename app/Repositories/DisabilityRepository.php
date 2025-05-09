<?php

namespace App\Repositories;

use App\Models\PatientDisability;

class DisabilityRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(PatientDisability $disability)
    {
        parent::__construct($disability, self::RELATIONS);
    }
}
