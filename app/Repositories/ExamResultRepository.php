<?php

namespace App\Repositories;

use App\Models\ExamResult;

class ExamResultRepository extends BaseRepository
{
    protected $model;

    public function __construct(ExamResult $model)
    {
        $this->model = $model;
    }
}
