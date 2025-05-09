<?php

namespace App\Http\Requests\PatientDisability;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientDisabilityRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        // Cambia esto según tu lógica de autorización
        return true;
    }

    /**
     * Obtén las reglas de validación que se aplican a la solicitud.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'reason' => 'sometimes|string|max:255',
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Obtén mensajes personalizados para los errores de validación.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.exists' => 'El usuario seleccionado no existe.',
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida.',
            'end_date.date' => 'La fecha de fin debe ser una fecha válida.',
            'end_date.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'reason.max' => 'El motivo no puede superar los 255 caracteres.',
            'is_active.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
        ];
    }
}
