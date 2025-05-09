<?php

namespace App\Services;

use App\Models\BranchCompany;
use App\Repositories\BranchCompanyRepository;

class BranchCompanyService
{
    public function __construct(private BranchCompanyRepository $branchCompanyRepository) {}

    public function getAllBranchCompanys()
    {
        return $this->branchCompanyRepository->all();
    }

    public function getBranchCompanyById(BranchCompany $branchCompany)
    {
        return $this->branchCompanyRepository->find($branchCompany);
    }

    public function createBranchCompany(array $data)
    {
        return $this->branchCompanyRepository->create($data);
    }

    public function updateBranchCompany(BranchCompany $branchCompany, array $data)
    {
        return $this->branchCompanyRepository->update($branchCompany, $data);
    }

    public function deleteBranchCompany(BranchCompany $branchCompany)
    {
        return $this->branchCompanyRepository->delete($branchCompany);
    }
}
