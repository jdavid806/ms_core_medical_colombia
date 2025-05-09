<?php

namespace App\Services\V2;

use Carbon\Carbon;
use App\Models\Appointment;
use App\Filters\AdmissionFilter;
use App\Models\AdmissionPending;
use App\Models\AppointmentState;
use App\Repositories\AdmissionPendingRepository;

class AdmissionPendingServiceV2
{
    public function __construct(private AdmissionPendingRepository $admissionPendingRepository) {}

    /* public function getFilteredPendingAdmissions(AdmissionFilter $filters, int $perPage)
    {

        $admissionPendingsQuery = $this->admissionPendingRepository->getPendingAdmissionsQuery();
    
 
        $filteredAdmissions = $filters->apply($admissionPendingsQuery);
    
        return $filteredAdmissions->paginate($perPage);
    } */


    public function getAllAdmissionPendings()
    {
        return $this->admissionPendingRepository->getPendingAdmissionsForToday();
    }
    /*
     public function getAdmissionPendingById(AdmissionPending $admissionPending)
    {
        return $this->admissionPendingRepository->find($admissionPending);
    }

    public function createAdmissionPending(array $data)
    {
        return $this->admissionPendingRepository->create($data);
    }

    public function updateAdmissionPending(AdmissionPending $admissionPending, array $data)
    {
        return $this->admissionPendingRepository->update($admissionPending, $data);
    }

    public function deleteAdmissionPending(AdmissionPending $admissionPending)
    {
        return $this->admissionPendingRepository->delete($admissionPending);
    } */
}
