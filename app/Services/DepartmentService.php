<?php

namespace App\Services;

use App\Models\Department;
use App\Repositories\DepartmentRepository;

class DepartmentService
{
    public function __construct(private DepartmentRepository $departmentRepository) {}

    public function getAllDepartments()
    {
        return $this->departmentRepository->all();
    }

    /* public function getCitiesByDepartment($department)
    {
        return $this->departmentRepository->getCitiesByState($department);
    } */

    public function getDepartmentById(Department $department)
    {
        return $this->departmentRepository->find($department);
    }

    public function createDepartment(array $data)
    {
        return $this->departmentRepository->create($data);
    }

    public function updateDepartment(Department $department, array $data)
    {
        return $this->departmentRepository->update($department, $data);
    }

    public function deleteDepartment(Department $department)
    {
        return $this->departmentRepository->delete($department);
    }

    public function getStatesByCountry($countryId)
    {
        return $this->departmentRepository->getDepartmentsByCountry($countryId);
    }
}
