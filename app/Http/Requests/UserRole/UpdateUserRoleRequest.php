<?php

namespace App\Http\Requests\UserRole;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRoleRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Cambia a `false` si necesitas lógica de autorización
    }

    /**
     * Reglas de validación para actualizar un rol de usuario.
     *
     * @return array
     */
    public function rules()
    {
        $userRoleId = $this->route('user_role'); // Obtén el ID del rol desde la ruta

        return [
            'name' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('user_roles', 'name')->ignore($userRoleId),
            ],
            'group' => [
                'sometimes',
                'string',
                'max:191',
                Rule::in(['DOCTOR', 'ADMIN', 'INDETERMINATE']),
            ],
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Mensajes de error personalizados en español.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no debe exceder los 50 caracteres.',
            'name.unique' => 'El nombre del rol ya está en uso.',
            'group.string' => 'El campo grupo debe ser una cadena de texto.',
            'group.max' => 'El campo grupo no debe exceder los 191 caracteres.',
            'group.in' => 'El campo grupo debe ser uno de los siguientes: DOCTOR, ADMIN, INDETERMINATE.',
            'is_active.boolean' => 'El campo activo debe ser verdadero o falso.',
        ];
    }
}
