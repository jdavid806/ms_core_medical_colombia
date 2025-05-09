<?php

namespace App\Http\Requests\PatientDisability;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientDisabilityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'El ID del usuario es obligatorio.',
            'user_id.exists' => 'El usuario seleccionado no existe.',
            'start_date.required' => 'La fecha de inicio es obligatoria.',
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida.',
            'end_date.required' => 'La fecha de fin es obligatoria.',
            'end_date.date' => 'La fecha de fin debe ser una fecha válida.',
            'end_date.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'reason.required' => 'El motivo es obligatorio.',
            'reason.max' => 'El motivo no puede superar los 255 caracteres.',
            'is_active.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
        ];
    }
}
