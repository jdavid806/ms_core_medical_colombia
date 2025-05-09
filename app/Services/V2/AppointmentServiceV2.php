<?php

namespace App\Services\V2;

use App\Models\Appointment;
use App\Traits\ApiResponses;
use App\Services\UserService;
use App\Repositories\AppointmentRepository;

class AppointmentServiceV2
{

    use ApiResponses;
    public function __construct(
        private AppointmentRepository $appointmentRepository,
        private UserService $userService,
    ) {}

    public function getAllAppointments(string $externalId, array $filters = [])
    {

        $user = $this->getAuthenticatedUser($externalId);
    
        if ($user->isDoctor()) {
            // Traer citas para el médico actual con filtros
            return $this->appointmentRepository->getScheduledAppointmentsForDoctor($user->id, $filters);
        }
    
        if ($user->isAdmin()) {
            // Traer citas para el administrador con filtros
            return $this->appointmentRepository->getAdminAdmissions($filters);
        }
    
        return [];
    }

    public function getAuthenticatedUser(string $externalId)
    {
        return $this->userService->getUserByExternalId($externalId);

    }

    public function getAppointmentById(Appointment $appointment)
    {
        return $this->appointmentRepository->find($appointment);
    }

    public function createAppointment(array $data)
    {
        return $this->appointmentRepository->create($data);
    }

    public function updateAppointment(Appointment $appointment, array $data)
    {
        return $this->appointmentRepository->update($appointment, $data);
    }

    public function deleteAppointment(Appointment $appointment)
    {
        return $this->appointmentRepository->delete($appointment);
    }

}
