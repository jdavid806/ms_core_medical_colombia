<?php

namespace App\Repositories;

use App\Models\ExamPackage;

class ExamPackageRepository extends BaseRepository
{
    protected $model;

    public function __construct(ExamPackage $model)
    {
        $this->model = $model;
    }
}
