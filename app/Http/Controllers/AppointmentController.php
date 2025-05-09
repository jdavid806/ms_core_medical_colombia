<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppointmentState;
use App\Services\AppointmentService;
use App\Http\Requests\Api\V1\BulkStoreAppointmentRequest;
use App\Http\Requests\Appointment\StoreAppointmentRequest;
use App\Http\Requests\Appointment\UpdateAppointmentRequest;
use App\Http\Requests\Api\V1\BulkAppointment\ValidateBulkAppointmentRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    protected $service;
    protected $relations = [
        'createdByUser',
        'patient',
        'patient.socialSecurity.entity',
        'patient.companions',
        'appointmentState',
        'userAvailability',
        'userAvailability.user',
        'userAvailability.appointmentType',
        'userAvailability.user.specialty',
        'userAvailability.user.specialty.specializables',
        'userAvailability.branch',
        'supervisorUserAvailability',
        'supervisorUserAvailability.user',
        'supervisorUserAvailability.appointmentType',
        'supervisorUserAvailability.user.specialty',
        'supervisorUserAvailability.user.specialty.specializables',
        'supervisorUserAvailability.branch',
        'examRecipe.details',
        'examRecipe.result',
        'examRecipe.user',
    ];

    public function __construct(AppointmentService $service)
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

    public function store(StoreAppointmentRequest $request, $patientId)
    {

        $xDomain = $request->header('X-DOMAIN');
        app()->instance('X-Domain-Global', $xDomain);


        return $this->service->createForParent($patientId, $request->validated());
    }

    public function bulkStore(BulkStoreAppointmentRequest $request, $patientId)
    {
        $xDomain = $request->header('X-DOMAIN');
        app()->instance('X-Domain-Global', $xDomain);


        return $this->service->createManyForParent($patientId, $request->validated()['appointments']);
    }


    public function validateBulk(ValidateBulkAppointmentRequest $request, $patientId)
    {
        $validatedAppointments = $request->validated()['appointments'];
        $errors = [];

        foreach ($validatedAppointments as $index => $appointmentData) {
            $validator = Validator::make($appointmentData, ValidateBulkAppointmentRequest::appointmentRules($appointmentData));

            if ($validator->fails()) {
                $errors[$index] = $validator->errors()->messages();
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'valid' => false,
                'errors' => $errors,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'valid' => true,
            'message' => 'Todas las citas son válidas.',
        ]);
    }


    public function recurringAppointment(StoreAppointmentRequest $request)
    {
        return $this->service->scheduleRecurringAppointment($request->all());
    }

    public function update(UpdateAppointmentRequest $request, $id)
    {
        $xDomain = $request->header('X-DOMAIN');
        app()->instance('X-Domain-Global', $xDomain);

        return $this->service->update($id, $request->validated());
    }

    public function destroy($id, Request $request)
    {
        $xDomain = $request->header('X-DOMAIN');
        app()->instance('X-Domain-Global', $xDomain);

        return $this->service->delete($id);
    }


    public function changeStatus(Request $request, $id, $statusKey)
    {
        $xDomain = $request->header('X-DOMAIN');
        app()->instance('X-Domain-Global', $xDomain);

        $state = AppointmentState::where('name', $statusKey)->first();
        $appointment = $this->service->getById($id)->load($this->relations);

        $appointment->update(['appointment_state_id' => $state->id]);

        return $appointment;
    }

    public function getLastByPatient($patientId)
    {
        return $this->service->getLastByPatient($patientId);
    }
}
