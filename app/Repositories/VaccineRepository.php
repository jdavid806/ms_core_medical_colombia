<?php

namespace App\Repositories;

use App\Models\Vaccine;
use Illuminate\Support\Facades\Log;

class VaccineRepository extends BaseRepository
{
    protected $model;

    public function __construct(Vaccine $model)
    {
        $this->model = $model;
    }

    public function updateOrCreate(array $data)
    {
        return $this->model->updateOrCreate(
            ['inventory_identifier' => $data['inventory_identifier']],
            $data
        );
    }
}
