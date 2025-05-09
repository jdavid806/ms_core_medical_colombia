<?php

namespace App\Services;

use App\Repositories\ModuleRepository;

class ModuleService extends BaseService
{
    protected $repository;

    public function __construct(ModuleRepository $repository)
    {
        $this->repository = $repository;
    }
}
