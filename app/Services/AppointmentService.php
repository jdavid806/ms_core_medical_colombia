<?php

namespace App\Services;

use App\Enum\FrequencyEnum;
use App\Events\WaitingRoom\AppointmentCreated;
use App\Events\WaitingRoom\AppointmentInactivated;
use App\Exceptions\JsonResponseException;
use App\Exceptions\UserAppointmentConflictException;
use App\Helpers\DateHelper;
use App\Helpers\EnumHelper;
use App\Models\AppointmentState;
use App\Models\ExamOrderState;
use App\Repositories\AppointmentRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentService extends OneToManyService
{
    protected $repository;
    protected $patientService;
    protected $userAvailabilityService;
    protected $inventoryService;
    protected $examOrderService;
    public $relations = [
        'createdByUser',
        'patient',
        'patient.socialSecurity',
        'patient.companions',
        'appointmentState',
        'userAvailability',
        'userAvailability.user',
        'userAvailability.appointmentType',
        'userAvailability.user.specialty',
        'userAvailability.branch',
    ];

    public function __construct(
        AppointmentRepository $repository,
        UserAvailabilityService $userAvailabilityService,
        InventoryService $inventoryService,
        ExamOrderService $examOrderService
    ) {
        $this->repository = $repository;
        $this->userAvailabilityService = $userAvailabilityService;
        $this->inventoryService = $inventoryService;
        $this->examOrderService = $examOrderService;
    }

    public function ofParent($parentId)
    {
        $result = parent::ofParent($parentId);
        $result->load(['patient']);
        $result->load(['userAvailability' => function ($query) {
            $query->with('user');
        }]);
        return $result;
    }

    public function createForParent($patientId, array $data)
    {
        return DB::transaction(function () use ($patientId, $data) {

            $associatedProduct = $this->inventoryService->getProductById($data['product_id']);

            $data['attention_type'] = $associatedProduct['attention_type'] == 'LABORATORY' ?
                'PROCEDURE' :
                $associatedProduct['attention_type'];

            $pendingState = AppointmentState::where('name', 'pending')->first();

            $data['appointment_state_id'] = $pendingState->id;

            $createdAppointment = parent::createForParent($patientId, $data);
            $createdAppointment->load($this->relations);

            if (
                $createdAppointment->userAvailability->appointment_type_id == 1 &&
                $createdAppointment->userAvailability->branch
            ) {
                AppointmentCreated::dispatch(
                    $createdAppointment,
                    app('X-Domain-Global'),
                    $createdAppointment->userAvailability->branch->id
                );
            }



            return $createdAppointment;
        });
    }

    public function createManyForParent($patientId, array $appointmentsData)
    {
        return DB::transaction(function () use ($patientId, $appointmentsData) {
            $createdAppointments = [];

            foreach ($appointmentsData as $data) {
                $associatedProduct = $this->inventoryService->getProductById($data['product_id']);

                $data['attention_type'] = $associatedProduct['attention_type'] == 'LABORATORY'
                    ? 'PROCEDURE'
                    : $associatedProduct['attention_type'];

                $pendingState = AppointmentState::where('name', 'pending')->first();
                $data['appointment_state_id'] = $pendingState->id;

                $createdAppointment = parent::createForParent($patientId, $data);
                $createdAppointment->load($this->relations);

                if (
                    $createdAppointment->userAvailability->appointment_type_id == 1 &&
                    $createdAppointment->userAvailability->branch
                ) {
                    AppointmentCreated::dispatch(
                        $createdAppointment,
                        app('X-Domain-Global'),
                        $createdAppointment->userAvailability->branch->id
                    );
                }

                $createdAppointments[] = $createdAppointment;
            }

            return $createdAppointments;
        });
    }



    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $appointment = parent::delete($id);
            $appointment->load($this->relations);

            if (
                $appointment->userAvailability->appointment_type_id == 1 &&
                $appointment->userAvailability->branch
            ) {
                AppointmentInactivated::dispatch(
                    $id,
                    app('X-Domain-Global'),
                    $appointment->userAvailability->branch_id,
                );
            }

            return $appointment;
        });
    }

    public function scheduleRecurringAppointment(array $data)
    {
        return DB::transaction(function () use ($data) {
            $frequency = EnumHelper::fromString(FrequencyEnum::class, $data['recurrence']);
            $repeatCount = $data['repeat_count'];
            $createdAppointments = [];

            $originalTime = $data['appointment_time'];

            for ($i = 0; $i < $repeatCount; $i++) {

                $appointmentDate = Carbon::parse($data['appointment_date']);
                if ($i != 0) DateHelper::addFrequencyToDate($appointmentDate, $frequency);

                $userAvailability = $this->userAvailabilityService->getById($data['assigned_user_availability_id']);
                $data['duration'] = $userAvailability->duration;
                $data['appointment_type_id'] = $userAvailability->appointment_type_id;
                $data['branch_id'] = $userAvailability->branch_id;
                $data['appointment_date'] = $appointmentDate->format('Y-m-d');
                $data['appointment_time'] = $originalTime;

                try {
                    $this->checkConflictingAppointment($data);
                    $createdAppointments[] = $this->create($data);
                } catch (\Throwable $th) {
                    $attempts = 0;
                    $maxAttempts = 7;

                    while (!$this->trySchedulingAppointment($data) && $attempts <= $maxAttempts) {
                        $attempts++;
                    }

                    if ($attempts >= $maxAttempts) {
                        throw new JsonResponseException('No ha sido posible agendar por completo las citas.');
                    }

                    $createdAppointments[] = $this->create($data);
                }
            }
            return $createdAppointments;
        });
    }

    private function trySchedulingAppointment(array &$data): bool
    {
        $availabilities = $this->userAvailabilityService->getDateAvailabilities($data);

        //dd($availabilities);

        foreach ($availabilities as $availability) {
            $data['assigned_user_availability_id'] = $availability->id;

            if ($this->attemptSchedulingInAvailability($data, $availability->toArray())) {
                return true;
            }
        }

        $data['appointment_date'] = Carbon::parse($data['appointment_date'])->addDay();
        return false;
    }

    private function attemptSchedulingInAvailability(array &$data, array $availabilityData): bool
    {
        $userAvailability = $this->userAvailabilityService->getById($availabilityData['id']);
        $data['appointment_type_id'] = $userAvailability->appointment_type_id;
        $data['branch_id'] = $userAvailability->branch_id;
        $data['duration'] = $userAvailability->duration;
        $data['user_id'] = $availabilityData['user_id'];
        $data['start_time'] = $availabilityData['start_time'];
        $data['end_time'] = $availabilityData['end_time'];

        $availableSlots = $this->userAvailabilityService->getAvailableSlots([
            'appointment_date' => $data['appointment_date'],
            'appointment_type_id' => $data['appointment_type_id'],
            'branch_id' => $data['branch_id'],
            'duration' => $data['duration'],
            'user_id' => $availabilityData['user_id'],
            'start_time' => $availabilityData['start_time'],
            'end_time' => $availabilityData['end_time'],
        ]);

        foreach ($availableSlots as $slot) {
            $data['appointment_time'] = $slot['start'];
            try {
                $this->checkConflictingAppointment($data);
                return true;
            } catch (\Throwable $th) {
                continue;
            }
        }

        return false;
    }

    public function checkConflictingAppointment($data, $excludeIds = [])
    {
        $conflictingAppointment = $this->repository->conflictingAppointment($data, $excludeIds);

        if ($conflictingAppointment) throw new UserAppointmentConflictException();
    }


    public function desactiveAppointment($appointmentId)
    {
        try {
            $appointment = $this->repository->find($appointmentId);

            $appointment->appointment_state_id = 3;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function changeStatus($appointmentId, $statusKey,)
    {

        $newState = AppointmentState::where('name', $statusKey)->first();

        return $this->update($appointmentId, ['appointment_state_id' => $newState->id]);
    }

    public function getLastByPatient($patientId)
    {
        return $this->repository->getLastByPatient($patientId);
    }
}
