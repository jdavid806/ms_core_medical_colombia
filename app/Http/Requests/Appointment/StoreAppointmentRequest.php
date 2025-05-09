<?php

namespace App\Http\Requests\Appointment;

use App\Rules\NoAppointmentConflictRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'appointment_time' => [
                'required',
                'date_format:H:i:s',
                new NoAppointmentConflictRule(
                    $this->input('appointment_date'),
                    $this->input('appointment_time'),
                    $this->input('assigned_user_availability_id')
                )
            ],
            'appointment_date' => ['required', 'date', 'after_or_equal:today',],
            'assigned_user_availability_id' => ['required', 'exists:user_availabilities,id'],
            'created_by_user_id' => ['required', 'exists:users,id'],
            'appointment_state_id' => ['required', 'exists:appointment_states,id'],
            'attention_type' => ['required', 'in:CONSULTATION,PROCEDURE, LABORATORY'],
            'consultation_purpose' => ['required', 'in:PROMOTION,PREVENTION,TREATMENT,REHABILITATION'],
            'consultation_type' => ['required', 'in:CONTROL,EMERGENCY,FIRST_TIME,FOLLOW_UP'],
            'external_cause' => ['required', 'in:ACCIDENT,OTHER,NOT_APPLICABLE'],
            'product_id' => ['integer'],
            'is_active' => ['nullable', 'boolean'],
            'supervisor_user_id' => ['nullable', 'exists:users,id'],
            'assigned_supervisor_user_availability_id' => ['nullable', 'exists:user_availabilities,id'],
            'exam_recipe_id' => ['nullable', 'exists:exam_recipes,id'],
        ];
    }

    public function messages()
    {
        return [
            'appointment_time.required' => 'La hora de la cita es obligatoria.',
            'appointment_time.date_format' => 'La hora de la cita debe estar en el formato HH:mm.',
            'appointment_date.required' => 'La fecha de la cita es obligatoria.',
            'appointment_date.date' => 'La fecha de la cita debe ser una fecha válida.',
            'appointment_date.after' => 'La fecha de la cita debe ser posterior a hoy.',
            'assigned_user_availability_id.required' => 'Debe asignarse una disponibilidad de usuario a la cita.',
            'assigned_user_availability_id.exists' => 'La disponibilidad de usuario no existe.',
            'created_by_user_id.required' => 'Debe indicarse el usuario que creó la cita.',
            'created_by_user_id.exists' => 'El usuario creador no existe.',
            'appointment_state_id.required' => 'El estado de la cita es obligatorio.',
            'appointment_state_id.exists' => 'El estado de la cita no existe.',
            'attention_type.required' => 'El tipo de atención es obligatorio.',
            'attention_type.in' => 'El tipo de atención debe ser CONSULTATION o PROCEDURE.',
            'consultation_purpose.required' => 'El propósito de la consulta es obligatorio.',
            'consultation_purpose.in' => 'El propósito de la consulta debe ser PROMOTION, PREVENTION, TREATMENT o REHABILITATION.',
            'consultation_type.required' => 'El tipo de consulta es obligatorio.',
            'consultation_type.in' => 'El tipo de consulta debe ser CONTROL, EMERGENCY, FIRST_TIME o FOLLOW_UP.',
            'external_cause.required' => 'La causa externa es obligatoria.',
            'external_cause.in' => 'La causa externa debe ser ACCIDENT, OTHER o NOT_APPLICABLE.',
            'is_active.boolean' => 'El estado de actividad debe ser verdadero o falso.',
            'exame_recipe_id.exists' => 'La receta de examen no existe.',
        ];
    }
}
