<?php

namespace App\Repositories;

use App\Models\UserRole;

class UserRoleRepository extends BaseRepository
{
    protected $model;

    public function __construct(UserRole $model)
    {
        $this->model = $model;
    }
}
