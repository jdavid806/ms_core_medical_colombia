<?php

namespace App\Repositories;

use App\Models\UserSpecialty;

class UserSpecialtyRepository extends BaseRepository
{
    protected $model;

    public function __construct(UserSpecialty $model)
    {
        $this->model = $model;
    }

    public function create(array $data): UserSpecialty
    {
        return $this->model::create($data);
    }
}
