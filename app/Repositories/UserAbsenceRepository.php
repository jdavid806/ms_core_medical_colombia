<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserAbsence;

class UserAbsenceRepository extends OneToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'absences';

    public function __construct(UserAbsence $model, User $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }
}
