<?php

namespace App\Repositories;

use App\Models\UserSpecialty;
use App\Models\UserSpecialtyMenu;

class UserSpecialtyMenuRepository extends ManyToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'menus';

    public function __construct(UserSpecialtyMenu $model, UserSpecialty $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }
}
