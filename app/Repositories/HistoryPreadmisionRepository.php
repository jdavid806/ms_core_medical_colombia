<?php

namespace App\Repositories;

use App\Models\HistoryPreadmission;

class HistoryPreadmisionRepository extends BaseRepository
{
    protected $model;

    public function __construct(HistoryPreadmission $model)
    {
        $this->model = $model;
    }

    public function historyByPatient($patientId, $isLast = 1)
    {
        if ($isLast) {
            return $this->model->where('patient_id', $patientId)->orderBy('id', 'desc')->first();
        } else {
            return $this->model->where('patient_id', $patientId)->get();
        }
    }
}
