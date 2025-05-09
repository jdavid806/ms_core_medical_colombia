<?php

namespace App\Http\Requests\Api\V1\BulkAppointment;

use App\Rules\NoAppointmentConflictRule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateBulkAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'appointments' => ['required', 'array', 'min:1'],
        ];
    }

    /**
     * Devuelve reglas individuales para una sola cita.
     */
    public static function appointmentRules(array $appointment): array
    {
        return [
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => [
                'required',
                'date_format:H:i:s',
                new NoAppointmentConflictRule(
                    $appointment['appointment_date'] ?? null,
                    $appointment['appointment_time'] ?? null,
                    $appointment['assigned_user_availability_id'] ?? null
                )
            ],
            'assigned_user_availability_id' => ['required', 'exists:user_availabilities,id'],
            'created_by_user_id' => ['required', 'exists:users,id'],
            'appointment_state_id' => ['required', 'exists:appointment_states,id'],
            'attention_type' => ['required', 'in:CONSULTATION,PROCEDURE,LABORATORY'],
            'consultation_purpose' => ['required', 'in:PROMOTION,PREVENTION,TREATMENT,REHABILITATION'],
            'consultation_type' => ['required', 'in:CONTROL,EMERGENCY,FIRST_TIME,FOLLOW_UP'],
            'external_cause' => ['required', 'in:ACCIDENT,OTHER,NOT_APPLICABLE'],
            'product_id' => ['required', 'integer'],
            'supervisor_user_id' => ['nullable', 'exists:users,id'],
            'assigned_supervisor_user_availability_id' => ['nullable', 'exists:user_availabilities,id'],
        ];
    }
}
