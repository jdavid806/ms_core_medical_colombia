<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\V2\AppointmentServiceV2;
use App\Http\Resources\Api\V2\Appointment\AppointmentResourceV2;
use App\Http\Requests\Api\V2\Appointment\StoreAppointmentRequestV2;
use App\Http\Requests\Api\V2\Appointment\UpdateAppointmentRequestV2;

class AppointmentControllerV2 extends Controller
{
    public function __construct(private AppointmentServiceV2 $appointmentService) {}

    public function index(Request $request, $externalId = null)
    {
        $filters = [
            'state' => $request->get('state'), // Filtro por estado
            'date_from' => $request->get('date_from'), // Fecha inicial
            'date_to' => $request->get('date_to'), // Fecha final
        ];
    
        $appointments = $this->appointmentService->getAllAppointments($externalId, $filters);
        return AppointmentResourceV2::collection($appointments);
    }

   /*  public function store(StoreAppointmentRequestV2 $request)
    {
        $appointment = $this->appointmentService->createAppointment($request->validated());
        return response()->json([
            'message' => 'Appointment created successfully',
            'Appointment' => $appointment,
        ]);
    }

    public function show(Appointment $appointment)
    {
        return new AppointmentResourceV2($appointment);
    }

    public function update(UpdateAppointmentRequestV2 $request, Appointment $appointment)
    {
        $this->appointmentService->updateAppointment($appointment, $request->validated());
        return response()->json([
            'message' => 'Appointment updated successfully',
        ]);
    }

    public function destroy(Appointment $appointment)
    {
        $this->appointmentService->deleteAppointment($appointment);
        return response()->json([
            'message' => 'Appointment deleted successfully',
        ]);
    } */

    //
}
