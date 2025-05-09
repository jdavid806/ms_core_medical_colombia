<?php

namespace App\Services;

use App\Models\BranchRepresentative;
use App\Repositories\BranchRepresentativeRepository;

class BranchRepresentativeService
{
    public function __construct(private BranchRepresentativeRepository $branchRepresentativeRepository) {}

    public function getAllBranchRepresentatives()
    {
        return $this->branchRepresentativeRepository->all();
    }

    public function getBranchRepresentativeById(BranchRepresentative $branchRepresentative)
    {
        return $this->branchRepresentativeRepository->find($branchRepresentative);
    }

    public function createBranchRepresentative(array $data)
    {
        return $this->branchRepresentativeRepository->create($data);
    }

    public function updateBranchRepresentative(BranchRepresentative $branchRepresentative, array $data)
    {
        return $this->branchRepresentativeRepository->update($branchRepresentative, $data);
    }

    public function deleteBranchRepresentative(BranchRepresentative $branchRepresentative)
    {
        return $this->branchRepresentativeRepository->delete($branchRepresentative);
    }
}
