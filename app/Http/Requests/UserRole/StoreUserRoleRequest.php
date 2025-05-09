<?php

namespace App\Http\Requests\UserRole;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRoleRequest extends FormRequest
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
     * Reglas de validación para crear un rol de usuario.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50|unique:user_roles,name',
            'group' => [
                'required',
                'string',
                'max:191',
                Rule::in(['DOCTOR', 'ADMIN', 'INDETERMINATE']),
            ],
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:user_role_permissions,id',
            'menus' => 'nullable|array',
            'menus.*' => 'exists:user_role_menus,id',
            'is_active' => 'boolean',
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
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no debe exceder los 50 caracteres.',
            'name.unique' => 'El nombre del rol ya está en uso.',
            'group.required' => 'El campo grupo es obligatorio.',
            'group.string' => 'El campo grupo debe ser una cadena de texto.',
            'group.max' => 'El campo grupo no debe exceder los 191 caracteres.',
            'group.in' => 'El campo grupo debe ser uno de los siguientes: DOCTOR, ADMIN, INDETERMINATE.',
            'is_active.boolean' => 'El campo activo debe ser verdadero o falso.',
        ];
    }
}
