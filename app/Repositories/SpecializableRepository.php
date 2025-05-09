<?php

namespace App\Repositories;

use App\Models\Specializable;

class SpecializableRepository extends BaseRepository
{
    protected $model;

    public function __construct(Specializable $model)
    {
        $this->model = $model;
    }

    public function clear($specialtyId)
    {
        $this->model->where('specialty_id', $specialtyId)->delete();
    }

    public function update($id, array $data)
    {
        $this->clear($id);
        foreach ($data as $item) {
            $this->model->create($item);
        }
    }

    public function getBySpecialty($specialtyId)
    {
        return $this->model->where('specialty_id', $specialtyId)->get();
    }
}
