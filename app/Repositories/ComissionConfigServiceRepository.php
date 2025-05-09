<?php

namespace App\Repositories;

use App\Models\ComissionConfigService;

class ComissionConfigServiceRepository extends BaseRepository
{
    protected $model;

    public function __construct(ComissionConfigService $model)
    {
        $this->model = $model;
    }
}
