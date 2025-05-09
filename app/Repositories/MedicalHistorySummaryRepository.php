<?php

namespace App\Repositories;

use App\Models\MedicalHistorySummary;

class MedicalHistorySummaryRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(MedicalHistorySummary $medicalHistorySummary)
    {
        parent::__construct($medicalHistorySummary, self::RELATIONS);
    }
}
