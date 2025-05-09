<?php

namespace App\Http\Requests\Appointment;

use App\Rules\NoAppointmentConflictRule;
use App\Services\AppointmentService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    public $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $appointment = $this->appointmentService->getById($this->route('appointment'));

        $appointmentDate = $this->input('appointment_date', $appointment->appointment_date);
        $appointmentTime = $this->input('appointment_time', $appointment->appointment_time);
        $assignedUserAvailabilityId = $this->input('assigned_user_availability_id', $appointment->assigned_user_availability_id);

        return [
            'appointment_time' => [
                'sometimes',
                'date_format:H:i:s',
                new NoAppointmentConflictRule(
                    $appointmentDate,
                    $appointmentTime,
                    $assignedUserAvailabilityId,
                    $appointment->id
                )
            ],
            'appointment_date' => ['sometimes', 'date', 'after_or_equal:today'],
            'assigned_user_availability_id' => ['sometimes', 'exists:user_availabilities,id'],
            'created_by_user_id' => ['sometimes', 'exists:users,id'],
            'appointment_state_id' => ['sometimes', 'exists:appointment_states,id'],
            'attention_type' => ['sometimes', 'in:CONSULTATION,PROCEDURE,LABORATORY'],
            'consultation_purpose' => ['sometimes', 'in:PROMOTION,PREVENTION,TREATMENT,REHABILITATION'],
            'consultation_type' => ['sometimes', 'in:CONTROL,EMERGENCY,FIRST_TIME,FOLLOW_UP'],
            'external_cause' => ['sometimes', 'in:ACCIDENT,OTHER,NOT_APPLICABLE'],
            'is_active' => ['sometimes', 'boolean'],
            'supervisor_user_id' => ['sometimes', 'exists:users,id'],
            'assigned_supervisor_user_availability_id' => ['sometimes', 'exists:user_availabilities,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'appointment_time.date_format' => 'La hora de la cita debe estar en el formato HH:i:s.',
            'appointment_date.date' => 'La fecha de la cita debe ser una fecha válida.',
            'appointment_date.after_or_equal' => 'La fecha de la cita no puede estar en el pasado.',
            'assigned_user_availability_id.exists' => 'La disponibilidad de usuario no existe.',
            'created_by_user_id.prohibited' => 'El usuario que creó la cita no puede ser modificado.',
            'appointment_state_id.exists' => 'El estado de la cita no existe.',
            'attention_type.in' => 'El tipo de atención debe ser CONSULTATION o PROCEDURE.',
            'consultation_purpose.in' => 'El propósito de la consulta debe ser PROMOTION, PREVENTION, TREATMENT o REHABILITATION.',
            'consultation_type.in' => 'El tipo de consulta debe ser CONTROL, EMERGENCY, FIRST_TIME o FOLLOW_UP.',
            'external_cause.in' => 'La causa externa debe ser ACCIDENT, OTHER o NOT_APPLICABLE.',
            'is_active.boolean' => 'El estado de actividad debe ser verdadero o falso.',
            'supervisor_user_id.exists' => 'El usuario supervisado no existe.',
            'assigned_supervisor_user_availability_id.exists' => 'La disponibilidad de supervisor no existe.',
        ];
    }
}
