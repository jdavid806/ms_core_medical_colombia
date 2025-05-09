<?php

namespace App\Repositories;

use App\Models\UserRole;
use App\Models\UserRolePermission;

class UserRolePermissionRepository extends ManyToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'permissions';

    public function __construct(UserRolePermission $model, UserRole $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }
}
