<?php

namespace App\Repositories;

use App\Models\Branch;

class BranchRepository extends BaseRepository
{
    protected $model;

    public function __construct(Branch $model)
    {
        $this->model = $model;
    }
}
