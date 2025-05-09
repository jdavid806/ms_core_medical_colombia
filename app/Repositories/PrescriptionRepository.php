<?php

namespace App\Repositories;

use App\Models\Prescription;

class PrescriptionRepository extends BaseRepository
{
    const RELATIONS = ['patient', 'prescriber', 'details'];

    public function __construct(Prescription $prescription)
    {
        parent::__construct($prescription, self::RELATIONS);
    }
}
