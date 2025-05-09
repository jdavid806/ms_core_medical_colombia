<?php

namespace App\Repositories;

use App\Models\ExamOrder;

class ExamOrderRepository extends BaseRepository
{
    protected $model;

    public function __construct(ExamOrder $model)
    {
        $this->model = $model;
    }

    public function getLastbyPatient($patientId)
    {
        return $this->model->where('patient_id', $patientId)
            ->orderBy('id', 'desc')
            ->first();
    }
}
