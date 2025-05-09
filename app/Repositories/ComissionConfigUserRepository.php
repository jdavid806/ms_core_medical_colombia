<?php

namespace App\Repositories;

use App\Models\ComissionConfigUser;

class ComissionConfigUserRepository extends BaseRepository
{
    protected $model;

    public function __construct(ComissionConfigUser $model)
    {
        $this->model = $model;
    }
}
