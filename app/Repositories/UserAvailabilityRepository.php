<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\User;
use App\Models\UserAvailability;
use Carbon\Carbon;

class UserAvailabilityRepository extends OneToManyRepository
{
    protected $model;
    protected $parentModel;
    protected string $childrenRelation = 'availabilities';

    public function __construct(UserAvailability $model, User $parentModel)
    {
        $this->model = $model;
        $this->parentModel = $parentModel;
    }

    public function getDateAvailabilities(array $data)
    {
        return $this->model
            ->active()
            ->ofAppointmentType($data['appointment_type_id'])
            ->ofDayOfWeek($data['appointment_date'])
            ->ofBranch($data['branch_id'] ?? null);
    }

    public function getAvailableSlots($data)
    {
        $start = Carbon::parse($data['start_time']);
        $end = Carbon::parse($data['end_time']);
        $occupiedMinutes = [];

        // Obtener citas existentes para esta disponibilidad
        $appointments = Appointment::active()
            ->where('assigned_user_availability_id', $data['assigned_user_availability_id'])
            ->byDate($data['appointment_date'])
            ->get();

        foreach ($appointments as $appointment) {
            $apptStart = Carbon::parse($appointment->appointment_time);
            $apptEnd = Carbon::parse($appointment->appointment_time)->addMinutes($appointment->duration);

            while ($apptStart->lt($apptEnd)) {
                $occupiedMinutes[$apptStart->format('H:i')] = true;
                $apptStart->addMinute();
            }
        }

        $slots = [];
        $currentSlotStart = null;
        $availableMinutes = 0;

        while ($start->lt($end)) {
            $time = $start->format('H:i');

            if (!isset($occupiedMinutes[$time])) {
                if ($currentSlotStart === null) {
                    $currentSlotStart = $time;
                }
                $availableMinutes++;
            } else {
                if ($availableMinutes >= $data['duration']) {
                    $slots[] = [
                        'start' => $currentSlotStart,
                        'end' => $start->format('H:i'),
                    ];
                }
                // Resetear variables
                $currentSlotStart = null;
                $availableMinutes = 0;
            }

            $start->addMinute();
        }

        if ($availableMinutes >= $data['duration']) {
            $slots[] = [
                'start' => $currentSlotStart,
                'end' => $end->format('H:i'),
            ];
        }

        return $slots;
    }
}
