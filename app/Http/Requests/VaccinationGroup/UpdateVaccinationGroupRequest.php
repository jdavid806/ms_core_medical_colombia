<?php

namespace App\Http\Requests\VaccinationGroup;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVaccinationGroupRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true; // Cambia según tu lógica de autorización
    }

    /**
     * Reglas de validación para la solicitud.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('vaccination_groups', 'name')->ignore($this->route('vaccination_group')),
            ],
            'description' => 'sometimes|nullable|string',
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Mensajes de error personalizados.
     */
    public function messages(): array
    {
        return [
            'name.string' => 'El campo "nombre" debe ser un texto.',
            'name.max' => 'El campo "nombre" no puede tener más de 255 caracteres.',
            'name.unique' => 'Ya existe un grupo de vacunación con este nombre.',
            'description.string' => 'El campo "descripción" debe ser un texto.',
            'is_active.boolean' => 'El campo "activo" debe ser verdadero o falso.',
        ];
    }
}
