<?php

namespace App\Http\Requests\VaccineApplication;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVaccineApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'group_vaccine_id' => 'sometimes|exists:group_vaccines,id',
            'applied_by_user_id' => 'sometimes|exists:users,id',
            'dose_number' => 'sometimes|integer|min:1',
            'is_booster' => 'sometimes|nullable|boolean',
            'description' => 'sometimes|nullable|string',
            'application_date' => 'sometimes|date|date_format:Y-m-d',
            'next_application_date' => 'sometimes|date|date_format:Y-m-d|after_or_equal:application_date',
            'is_active' => 'sometimes|nullable|boolean',
        ];
    }

    /**
     * Get the custom error messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'group_vaccine_id.exists' => 'El grupo de vacuna seleccionado no existe.',
            'applied_by_user_id.exists' => 'El usuario aplicador de la vacuna no existe.',
            'dose_number.integer' => 'El número de dosis debe ser un número entero.',
            'dose_number.min' => 'El número de dosis debe ser al menos 1.',
            'is_booster.boolean' => 'El campo "es refuerzo" debe ser verdadero o falso.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'application_date.date' => 'La fecha de aplicación debe ser una fecha válida.',
            'next_application_date.date' => 'La próxima fecha de aplicación debe ser una fecha válida.',
            'next_application_date.after_or_equal' => 'La próxima fecha de aplicación debe ser posterior o igual a la fecha de aplicación.',
            'is_active.boolean' => 'El estado de activación debe ser verdadero o falso.',
        ];
    }
}
