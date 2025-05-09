<?php

namespace App\Services;

use App\Repositories\HistoryPreadmisionRepository;

class HistoryPreadmissionService extends OneToManyService
{
    protected $repository;

    public function __construct(HistoryPreadmisionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function historyByPatient($patientId, $isLast = 1)
    {
        return $this->repository->historyByPatient($patientId, $isLast);
    }
}
