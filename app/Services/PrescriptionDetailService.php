<?php

namespace App\Services;

use App\Models\PrescriptionDetail;
use App\Repositories\PrescriptionDetailRepository;

class PrescriptionDetailService
{
    public function __construct(private PrescriptionDetailRepository $prescriptionDetailRepository) {}

    public function getAllPrescriptionDetails()
    {
        return $this->prescriptionDetailRepository->all();
    }

    public function getPrescriptionDetailById(PrescriptionDetail $prescriptionDetail)
    {
        return $this->prescriptionDetailRepository->find($prescriptionDetail);
    }

    public function createPrescriptionDetail(array $data)
    {
        return $this->prescriptionDetailRepository->create($data);
    }

    public function updatePrescriptionDetail(PrescriptionDetail $prescriptionDetail, array $data)
    {
        return $this->prescriptionDetailRepository->update($prescriptionDetail, $data);
    }

    public function deletePrescriptionDetail(PrescriptionDetail $prescriptionDetail)
    {
        return $this->prescriptionDetailRepository->delete($prescriptionDetail);
    }
}
