<?php

namespace App\Http\Requests\VaccinationGroup;

use Illuminate\Foundation\Http\FormRequest;

class StoreVaccinationGroupRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para la solicitud.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:vaccination_groups,name',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Mensajes de error personalizados.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser un texto.',
            'name.max' => 'El campo nombre no puede tener más de 255 caracteres.',
            'name.unique' => 'Ya existe un grupo de vacunación con este nombre.',
            'description.string' => 'El campo "descripción" debe ser un texto.',
            'is_active.boolean' => 'El campo "activo" debe ser verdadero o falso.',
        ];
    }
}
