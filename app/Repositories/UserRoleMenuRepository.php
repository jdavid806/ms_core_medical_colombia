<?php

namespace App\Repositories;

use App\Models\UserRole;
use App\Models\UserRoleMenu;

class UserRoleMenuRepository extends ManyToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'menus';

    public function __construct(UserRoleMenu $model, UserRole $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }
}
