<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Admission;

class AdmissionRepository extends OneToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'admissions';

    public function __construct(Admission $model, Patient $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }


}
