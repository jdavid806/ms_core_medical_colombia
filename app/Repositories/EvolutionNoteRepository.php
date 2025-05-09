<?php

namespace App\Repositories;

use App\Models\ClinicalEvolutionNote;

class EvolutionNoteRepository extends BaseRepository
{

    const RELATIONS = ['clinicalRecord', 'createdByUser'];
    public function __construct(ClinicalEvolutionNote $clinicalEvolution)
    {
        parent::__construct($clinicalEvolution, self::RELATIONS);
    }
}
