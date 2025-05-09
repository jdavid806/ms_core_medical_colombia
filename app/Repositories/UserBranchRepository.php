<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserBranch;

class UserBranchRepository extends ManyToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'branches';

    public function __construct(UserBranch $model, User $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }
}
