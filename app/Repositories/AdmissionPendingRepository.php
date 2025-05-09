<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\AdmissionPending;
use App\Models\AppointmentState;

class AdmissionPendingRepository extends BaseRepository
{
    const RELATIONS = ['assignedUserAvailability', 'createdByUser', 'patient', 'appointmentState', 'userAvailability'];

    public function __construct(Appointment $admissionPending)
    {
        parent::__construct($admissionPending, self::RELATIONS);
    }

    public function getPendingAdmissionsForToday()
    {
        $status = AppointmentState::where('name', 'pending')->first();
        if (!$status) {
            return [];
        }
        $statusId = $status->id;
        $today = Carbon::today();

        return $this->model->where('appointment_state_id', $statusId)
            ->whereDate('appointment_date', $today)
            ->with(['patient'])
            ->get();
    }


    public function getPendingAdmissionsQuery()
    {
        $status = AppointmentState::where('name', 'pending')->first();
        if (!$status) {
            return $this->model->newQuery(); // Retorna un query vacío si no hay estado "pending"
        }
    
        $statusId = $status->id;
        $today = Carbon::today();
    
        // Retorna el query para que se puedan aplicar filtros
        return $this->model->where('appointment_state_id', $statusId)
            ->whereDate('appointment_date', $today)
            ->with(['patient']);
    }
}
