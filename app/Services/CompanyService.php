<?php

namespace App\Services;

use App\Models\Company;
use App\Repositories\CompanyRepository;

class CompanyService
{
    public function __construct(private CompanyRepository $companyRepository) {}

    public function getAllCompanys()
    {
        return $this->companyRepository->all();
    }

    public function getCompanyById(Company $company)
    {
        return $this->companyRepository->find($company);
    }

    public function createCompany(array $data)
    {
        return $this->companyRepository->create($data);
    }

    public function updateCompany($company, array $data)
    {
        return $this->companyRepository->update($company, $data);
    }

    public function deleteCompany(Company $company)
    {
        return $this->companyRepository->delete($company);
    }
}
