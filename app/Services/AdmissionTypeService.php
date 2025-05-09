<?php

namespace App\Services;

use App\Models\AdmissionType;
use App\Repositories\AdmissionTypeRepository;

class AdmissionTypeService
{
    public function __construct(private AdmissionTypeRepository $admissiontypeRepository) {}

    public function getAllAdmissionTypes()
    {
        return $this->admissiontypeRepository->all();
    }

    public function getAdmissionTypeById(AdmissionType $admissiontype)
    {
        return $this->admissiontypeRepository->find($admissiontype);
    }

    public function createAdmissionType(array $data)
    {
        return $this->admissiontypeRepository->create($data);
    }

    public function updateAdmissionType(AdmissionType $admissiontype, array $data)
    {
        return $this->admissiontypeRepository->update($admissiontype, $data);
    }

    public function deleteAdmissionType(AdmissionType $admissiontype)
    {
        return $this->admissiontypeRepository->delete($admissiontype);
    }
}
