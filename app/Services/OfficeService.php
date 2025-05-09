<?php

namespace App\Services;

use App\Models\Office;
use App\Repositories\OfficeRepository;

class OfficeService
{
    public function __construct(private OfficeRepository $officeRepository) {}

    public function getAllOffices()
    {
        return $this->officeRepository->all();
    }

    public function getOfficeById(Office $office)
    {
        return $this->officeRepository->find($office);
    }

    public function createOffice(array $data)
    {
        return $this->officeRepository->create($data);
    }

    public function updateOffice(Office $office, array $data)
    {
        return $this->officeRepository->update($office, $data);
    }

    public function deleteOffice(Office $office)
    {
        return $this->officeRepository->delete($office);
    }
}
