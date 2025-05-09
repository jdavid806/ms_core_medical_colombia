<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\VaccineApplication;

class VaccineApplicationRepository extends OneToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'vaccineApplications';

    public function __construct(VaccineApplication $model, Patient $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }
}
