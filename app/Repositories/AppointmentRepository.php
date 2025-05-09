<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\AppointmentState;
use App\Models\Patient;
use Carbon\Carbon;

class AppointmentRepository extends OneToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'appointments';

    public function __construct(Appointment $model, Patient $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }

    public function conflictingAppointment($data, $excludeIds = [])
    {
        $startTime = $data['appointment_time'];
        $endTime = Carbon::parse($startTime)->addMinutes($data['duration'])->format('H:i');

        return $this->model->query()
            ->where('assigned_user_availability_id', $data['assigned_user_availability_id'])
            ->where('appointment_date', $data['appointment_date'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('appointment_time', '>', $startTime)
                        ->where('appointment_time', '<', $endTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    $q->whereRaw("appointment_time + interval '1 minute' * duration > ?", [$startTime])
                        ->where('appointment_time', '<', $endTime);
                });
            })
            ->where('is_active', true)
            ->whereNotIn('id', $excludeIds)
            ->exists();
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

    public function getScheduledAppointmentsForDoctor($doctorId, array $filters = [])
    {
        $query = $this->model->where('assigned_user_availability_id', $doctorId)
            ->whereHas('appointmentState', function ($query) {
                $query->whereNotIn('name', ['pending', 'cancelled']);
            });

        // Aplicar filtros
        if (!empty($filters['state'])) {
            $query->whereHas('appointmentState', function ($q) use ($filters) {
                $q->where('name', $filters['state']);
            });
        }

        if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
            $query->whereBetween('appointment_date', [$filters['date_from'], $filters['date_to']]);
        }

        return $query->with(['patient', 'assignedUserAvailability', 'appointmentState'])->get();
    }

    public function getAdminAdmissions(array $filters = [])
    {
        $query = $this->model->whereHas('appointmentState', function ($query) {
            $query->whereNotIn('name', ['pending', 'cancelled']); // Cambiado a whereNotIn
        });

        // Aplicar filtros
        if (!empty($filters['state'])) {
            $query->whereHas('appointmentState', function ($q) use ($filters) {
                $q->where('name', $filters['state']);
            });
        }

        if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
            $query->whereBetween('appointment_date', [$filters['date_from'], $filters['date_to']]);
        }

        return $query->with(['patient', 'assignedUserAvailability', 'appointmentState'])->get();
    }

    public function getLastByPatient($patientId)
    {
        return $this->model->query()
            ->where('patient_id', $patientId)
            ->orderBy('id', 'desc')
            ->first();
    }
}
