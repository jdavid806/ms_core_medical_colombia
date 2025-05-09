<?php

namespace App\Repositories;

use App\Models\Module;

class ModuleRepository extends BaseRepository
{
    protected $model;

    public function __construct(Module $model)
    {
        $this->model = $model;
    }
}
