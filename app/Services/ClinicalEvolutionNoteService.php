<?php

namespace App\Services;

use App\Repositories\ClinicalEvolutionNoteRepository;

class ClinicalEvolutionNoteService extends OneToManyService
{
    protected $repository;

    public function __construct(ClinicalEvolutionNoteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getEvolutionByParams($startDate, $endDate, $userId, $patientId)
    {
        return $this->repository->getEvolutionByParams($startDate, $endDate, $userId, $patientId);
    }
}
