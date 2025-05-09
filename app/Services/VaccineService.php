<?php

namespace App\Services;

use App\Repositories\VaccineRepository;

class VaccineService extends BaseService
{
    protected $repository;

    public function __construct(VaccineRepository $repository)
    {
        $this->repository = $repository;
    }

    public function syncVaccines(array $vaccinesData)
    {
        foreach ($vaccinesData as $data) {
            $this->updateOrCreate($data);
        }
    }
}
