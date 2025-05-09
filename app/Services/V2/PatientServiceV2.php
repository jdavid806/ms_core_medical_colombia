<?php

namespace App\Services\V2;

use Carbon\Carbon;
use App\Models\Patient;
use App\Traits\ApiResponses;
use App\Services\UserService;
use Illuminate\Http\Response;
use App\Exceptions\PatientException;
use App\Repositories\PatientRepository;

class PatientServiceV2
{
    use ApiResponses; // Usamos el trait aquí
    public function __construct(
        private PatientRepository $patientRepository,
        private UserService $userService,
    ) {}


    public function getAllPatients(array $filters, string $externalId)
    {
        $user = $this->getAuthenticatedUser($externalId);
        if (!$user) {
            return $this->error('User not found', 404);
        }

        if (!$this->isAuthorized($user)) {
            return $this->error('Unauthorized', 403);
        }

        $day = Carbon::now()->format('Y-m-d');
        $perPage = request()->get('per_page', 10); // Obtén el número de registros por página desde la solicitud

        $patients = $this->getPatientsByRole($user, $day, $filters, $perPage);

        if ($patients->isEmpty()) {
            return $this->ok('No hay citas disponibles en este momento para el día de hoy');
        }

        return $this->success('Pacientes encontrados', $patients);
    }

    public function getAllPatientsWithAppointments(array $filters, string $externalId)
    {
        $user = $this->getAuthenticatedUser($externalId);
        if (!$user) {
            return $this->error('User not found', 404);
        }

        if (!$this->isAuthorized($user)) {
            return $this->error('Unauthorized', 403);
        }

        $day = Carbon::now()->format('Y-m-d');
        $perPage = request()->get('per_page', 10); // Obtén el número de registros por página desde la solicitud

        $patients = $this->getPatientsWithAppointmentsByRole($user, $day, $filters, $perPage);

        if ($patients->isEmpty()) {
            return $this->ok('No hay citas disponibles en este momento para el día de hoy');
        }

        return $this->success('Pacientes encontrados', $patients);
    }

    private function getAuthenticatedUser($externalId)
    {
        return $this->userService->getUserByExternalId($externalId);
    }

    private function isAuthorized($user)
    {
        return in_array($user->role->group, ['DOCTOR', 'ADMIN']);
    }

    private function getPatientsByRole($user, $day, array $filters, $perPage)
    {
        return match (true) {
            $user->isDoctor() => $this->patientRepository->getPatientsForDoctor($user->id, $day, $filters, $perPage),
            $user->isAdmin()  => $this->patientRepository->getPatientsForAdmin($filters, $perPage),
            default           => collect()
        };
    }

    private function getPatientsWithAppointmentsByRole($user, $day, array $filters, $perPage)
    {
        return match (true) {
            $user->isDoctor() => $this->patientRepository->getPatientsWithAppointmentsForDoctor($user->id, $day, $filters, $perPage),
            $user->isAdmin()  => $this->patientRepository->getPatientsWithAppointmentsForAdmin($day, $filters, $perPage),
            default           => collect()
        };
    }

    public function getPatients($filters, $perPage)
    {
        try {
            return Patient::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new PatientException('Failed to retrieve patients', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
