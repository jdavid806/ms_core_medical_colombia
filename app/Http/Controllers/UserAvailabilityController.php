<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAvailability\StoreUserAvailabilityRequest;
use App\Http\Requests\UserAvailability\UpdateUserAvailabilityRequest;
use App\Models\Appointment;
use App\Models\UserAvailability;
use App\Services\UserAvailabilityService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserAvailabilityController extends Controller
{
    protected $service;
    protected $relations = ['user', 'appointmentType', 'branch', 'freeSlots'];

    public function __construct(UserAvailabilityService $service)
    {
        $this->service = $service;
    }

    public function index($patientId)
    {
        return $this->service->ofParent($patientId)->load($this->relations);
    }

    public function show($id)
    {
        return $this->service->getById($id)->load($this->relations);
    }

    public function store(StoreUserAvailabilityRequest $request, $patientId)
    {
        return $this->service->createForParent($patientId, $request->validated());
    }

    public function update(UpdateUserAvailabilityRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    public function availableBlocks(Request $request)
    {
        $startDate = Carbon::today();
        $endDate   = Carbon::now()->addYear()->addMonth();

        $specialty    = $request->input('user_specialty_id');
        $professional = $request->input('user_id');
        $period       = strtoupper($request->input('period'));

        $availabilitiesQuery = UserAvailability::with([
            'freeSlots',
            'user.assistants.availabilities',
            'branch',
            'appointmentType',
        ])
            ->where('is_active', true);

        if ($professional) {
            $availabilitiesQuery->where('user_id', $professional);
        }
        if ($specialty) {
            $availabilitiesQuery->whereHas('user', function ($q) use ($specialty) {
                $q->where('user_specialty_id', $specialty);
            });
        }
        $availabilities = $availabilitiesQuery->get();

        if ($availabilities->isEmpty()) {
            return response()->json([]);
        }

        $appointments = Appointment::whereIn('assigned_user_availability_id', $availabilities->pluck('id'))
            ->whereBetween('appointment_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->where('is_active', true)
            ->get()
            ->groupBy(['assigned_user_availability_id', 'appointment_date']);

        $result = [];

        foreach ($availabilities as $availability) {
            $this->processAvailability($availability, $startDate, $endDate, $appointments, $result, $period);
        }

        return response()->json($result);
    }

    protected function processAvailability(
        UserAvailability $availability,
        Carbon $startDate,
        Carbon $endDate,
        Collection $appointments,
        array &$result,
        ?string $period = null
    ): void {

        $daysOfWeek = is_array($availability->days_of_week)
            ? $availability->days_of_week
            : json_decode($availability->days_of_week, true);
        $periodDates = CarbonPeriod::create($startDate, $endDate)
            ->filter(fn($date) => in_array($date->dayOfWeek, $daysOfWeek));

        $dayOptions = [];
        foreach ($periodDates as $date) {
            $dayStr = $date->format('Y-m-d');

            $segments = $this->initializeSegments($availability, $dayStr);
            $segments = $this->applyFreeSlots($availability, $dayStr, $segments);
            $segments = $this->applyAppointments($appointments, $availability, $dayStr, $segments);

            if ($period) {
                $filteredSegments = [];
                foreach ($segments as $segment) {
                    $startHour = (int)$segment['start']->format('H');
                    if ($period === 'AM' && $startHour < 12) {
                        $filteredSegments[] = $segment;
                    } elseif ($period === 'PM' && $startHour >= 12) {
                        $filteredSegments[] = $segment;
                    }
                }
                $segments = $filteredSegments;
            }

            if (!empty($segments)) {
                $dayOptions[] = [
                    'date' => $dayStr,
                    'blocks' => array_map(fn($seg) => [
                        'start_time' => $seg['start']->format('H:i:s'),
                        'end_time'   => $seg['end']->format('H:i:s')
                    ], $segments)
                ];
            }
        }

        if (!empty($dayOptions)) {
            $dayOptions = array_slice($dayOptions, 0, 396);
            $result[] = [
                'availability_id'      => $availability->id,
                'appointment_duration' => $availability->appointment_duration,
                'appointment_type'     => $availability->appointmentType,
                'user'                 => $availability->user,
                'user_specialty'       => $availability->user->specialty,
                'branch'               => $availability->branch,
                'days'                 => $dayOptions
            ];
        }
    }

    protected function initializeSegments(UserAvailability $availability, string $dayStr): array
    {
        return [
            [
                'start' => Carbon::parse("$dayStr {$availability->start_time}"),
                'end'   => Carbon::parse("$dayStr {$availability->end_time}")
            ]
        ];
    }

    protected function applyFreeSlots(UserAvailability $availability, string $dayStr, array $segments): array
    {
        foreach ($availability->freeSlots as $slot) {
            $segments = $this->subtractTimeRange(
                $segments,
                Carbon::parse("$dayStr {$slot->start_time}"),
                Carbon::parse("$dayStr {$slot->end_time}")
            );
        }
        return $segments;
    }

    protected function applyAppointments(
        Collection $appointments,
        UserAvailability $availability,
        string $dayStr,
        array $segments
    ): array {

        $appointmentsForDay = $appointments
            ->get($availability->id, collect())
            ->get($dayStr, []);

        foreach ($appointmentsForDay as $appointment) {
            $appointmentStart = Carbon::parse("$dayStr {$appointment->appointment_time}");
            $appointmentEnd = (clone $appointmentStart)->addMinutes($availability->appointment_duration);
            $segments = $this->subtractTimeRange(
                $segments,
                $appointmentStart,
                $appointmentEnd
            );
        }
        return $segments;
    }

    protected function subtractTimeRange(array $segments, Carbon $rangeStart, Carbon $rangeEnd): array
    {
        $newSegments = [];
        foreach ($segments as $segment) {
            if ($rangeEnd <= $segment['start'] || $rangeStart >= $segment['end']) {
                $newSegments[] = $segment;
                continue;
            }
            if ($segment['start'] < $rangeStart) {
                $newSegments[] = ['start' => $segment['start'], 'end' => $rangeStart];
            }
            if ($segment['end'] > $rangeEnd) {
                $newSegments[] = ['start' => $rangeEnd, 'end' => $segment['end']];
            }
        }
        return $newSegments;
    }
}
