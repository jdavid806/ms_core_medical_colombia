<?php

namespace App\Repositories;

use App\Models\ExamOrderState;

class ExamOrderStateRepository extends BaseRepository
{
    protected $model;

    public function __construct(ExamOrderState $model)
    {
        $this->model = $model;
    }
}
