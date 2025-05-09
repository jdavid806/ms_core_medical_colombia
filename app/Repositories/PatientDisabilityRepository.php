<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\PatientDisability;

class PatientDisabilityRepository extends OneToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'disabilities';

    public function __construct(PatientDisability $model, Patient $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }

    public function getLastByPatient($patientId)
    {
        return $this->model->where('patient_id', $patientId)->orderBy('id', 'desc')
            ->first();
    }
}
