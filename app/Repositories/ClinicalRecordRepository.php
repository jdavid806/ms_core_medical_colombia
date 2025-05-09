<?php

namespace App\Repositories;

use App\Models\ClinicalRecord;
use App\Models\Patient;

class ClinicalRecordRepository extends OneToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'clinicalRecords';

    public function __construct(ClinicalRecord $model, Patient $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }

    function getByType($type, $patientId)
    {

        return $this->model->where('patient_id', $patientId)->whereHas('clinicalRecordType', function ($query) use ($type) {
            $query->where("key_", $type);
        })->get();
    }

    public function getLastByPatient($patientId)
    {
        return $this->model->where('patient_id', $patientId)
            ->orderBy('id', 'desc')
            ->first();
    }
}
