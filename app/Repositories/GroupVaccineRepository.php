<?php

namespace App\Repositories;

use App\Models\GroupVaccine;
use App\Models\VaccinationGroup;

class GroupVaccineRepository extends ManyToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'groupVaccines';

    public function __construct(GroupVaccine $model, VaccinationGroup $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }
}
