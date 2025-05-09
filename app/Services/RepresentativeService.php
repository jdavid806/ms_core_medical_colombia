<?php

namespace App\Services;

use App\Models\Representative;
use App\Repositories\RepresentativeRepository;

class RepresentativeService
{
    public function __construct(private RepresentativeRepository $representativeRepository) {}

    public function getAllRepresentatives()
    {
        return $this->representativeRepository->all();
    }

    public function getRepresentativeById(Representative $representative)
    {
        return $this->representativeRepository->find($representative);
    }

    public function createRepresentative(array $data)
    {
        return $this->representativeRepository->create($data);
    }

    public function updateRepresentative(array $data, Representative $representative)
    {
        return $this->representativeRepository->update($representative, $data);
    }

    public function deleteRepresentative(Representative $representative)
    {
        return $this->representativeRepository->delete($representative);
    }
}
