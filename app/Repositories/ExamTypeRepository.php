<?php

namespace App\Repositories;

use App\Models\ExamType;

class ExamTypeRepository extends BaseRepository
{
    protected $model;

    public function __construct(ExamType $model)
    {
        $this->model = $model;
    }
}
