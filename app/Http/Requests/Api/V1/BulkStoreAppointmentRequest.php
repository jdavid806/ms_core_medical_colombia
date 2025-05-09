<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\NoAppointmentConflictRule;
use Illuminate\Foundation\Http\FormRequest;

class BulkStoreAppointmentRequest extends FormRequest
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
    public function rules(): array
    {
        $rules = [
            'appointments' => 'required|array|min:1',
        ];

        foreach ($this->input('appointments', []) as $index => $appointment) {
            $rules["appointments.$index.appointment_date"] = ['required', 'date'];
            $rules["appointments.$index.appointment_time"] = [
                'required',
                'date_format:H:i:s',
                new NoAppointmentConflictRule(
                    $appointment['appointment_date'] ?? null,
                    $appointment['appointment_time'] ?? null,
                    $appointment['assigned_user_availability_id'] ?? null
                )
            ];
            $rules["appointments.$index.assigned_user_availability_id"] = ['required', 'integer'];
            $rules["appointments.$index.product_id"] = ['required', 'integer'];

            // Nuevos campos requeridos para la creación
            $rules["appointments.$index.created_by_user_id"] = ['required', 'exists:users,id'];
            $rules["appointments.$index.appointment_state_id"] = ['required', 'exists:appointment_states,id'];
            $rules["appointments.$index.attention_type"] = ['required', 'in:CONSULTATION,PROCEDURE,LABORATORY'];
            $rules["appointments.$index.consultation_purpose"] = ['required', 'in:PROMOTION,PREVENTION,TREATMENT,REHABILITATION'];
            $rules["appointments.$index.consultation_type"] = ['required', 'in:CONTROL,EMERGENCY,FIRST_TIME,FOLLOW_UP'];
            $rules["appointments.$index.external_cause"] = ['required', 'in:ACCIDENT,OTHER,NOT_APPLICABLE'];
            $rules["appointments.$index.supervisor_user_id"] = ['nullable', 'exists:users,id'];
            $rules["appointments.$index.assigned_supervisor_user_availability_id"] = ['nullable', 'exists:user_availabilities,id'];
            $rules["appointments.$index.exam_recipe_id"] = ['nullable', 'exists:exam_recipes,id'];
        }

        return $rules;
    }
}
