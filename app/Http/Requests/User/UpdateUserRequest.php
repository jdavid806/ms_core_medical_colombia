<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        // Ajusta la lógica de autorización según tus necesidades.
        return true;
    }

    public function rules()
    {
        return [
            'first_name'         => 'sometimes|required|string|max:255',
            'middle_name'        => 'sometimes|nullable|string|max:255',
            'last_name'          => 'sometimes|required|string|max:255',
            'second_last_name'   => 'sometimes|nullable|string|max:255',
            'external_id'        => 'sometimes|required|string|max:255',
            'user_role_id'       => 'sometimes|required|integer|exists:user_roles,id',
            'user_specialty_id'  => 'sometimes|nullable|integer|exists:user_specialties,id',
            'is_active'          => 'sometimes|required|boolean',
            'country_id'         => 'sometimes|required|string',
            'city_id'            => 'sometimes|required|string',
            'gender'             => 'sometimes|required|in:MALE,FEMALE,OTHER',
            'address'            => 'sometimes|required|string',
            'phone'              => 'sometimes|required|string|max:20',
            'email'              => 'sometimes|required|email|max:255',
            'data'               => 'sometimes|nullable|array',
            'minio_id'           => 'sometimes|nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required'       => 'El campo "Nombre" es obligatorio cuando se envía.',
            'first_name.string'         => 'El campo "Nombre" debe ser un texto.',
            'first_name.max'            => 'El campo "Nombre" no debe tener más de 255 caracteres.',

            'middle_name.string'        => 'El campo "Segundo Nombre" debe ser un texto.',
            'middle_name.max'           => 'El campo "Segundo Nombre" no debe tener más de 255 caracteres.',

            'last_name.required'        => 'El campo "Apellido" es obligatorio cuando se envía.',
            'last_name.string'          => 'El campo "Apellido" debe ser un texto.',
            'last_name.max'             => 'El campo "Apellido" no debe tener más de 255 caracteres.',

            'second_last_name.string'   => 'El campo "Segundo Apellido" debe ser un texto.',
            'second_last_name.max'      => 'El campo "Segundo Apellido" no debe tener más de 255 caracteres.',

            'external_id.required'      => 'El campo "Identificador Externo" es obligatorio cuando se envía.',
            'external_id.string'        => 'El campo "Identificador Externo" debe ser un texto.',
            'external_id.max'           => 'El campo "Identificador Externo" no debe tener más de 255 caracteres.',

            'user_role_id.required'     => 'El campo "Rol de Usuario" es obligatorio cuando se envía.',
            'user_role_id.integer'      => 'El campo "Rol de Usuario" debe ser un número entero.',
            'user_role_id.exists'       => 'El rol de usuario seleccionado no existe.',

            'user_specialty_id.integer' => 'El campo "Especialidad de Usuario" debe ser un número entero.',
            'user_specialty_id.exists'  => 'La especialidad de usuario seleccionada no existe.',

            'is_active.required'        => 'El campo "Activo" es obligatorio cuando se envía.',
            'is_active.boolean'         => 'El campo "Activo" debe ser verdadero o falso.',

            'country_id.required'       => 'El campo "País" es obligatorio cuando se envía.',

            'city_id.required'          => 'El campo "Ciudad" es obligatorio cuando se envía.',

            'gender.required'           => 'El campo "Género" es obligatorio cuando se envía.',
            'gender.in'                 => 'El campo "Género" debe ser MALE, FEMALE u OTHER.',

            'address.required'          => 'El campo "Dirección" es obligatorio cuando se envía.',
            'address.string'            => 'El campo "Dirección" debe ser un texto.',

            'phone.required'            => 'El campo "Teléfono" es obligatorio cuando se envía.',
            'phone.string'              => 'El campo "Teléfono" debe ser un texto.',
            'phone.max'                 => 'El campo "Teléfono" no debe tener más de 20 caracteres.',

            'email.required'            => 'El campo "Correo Electrónico" es obligatorio cuando se envía.',
            'email.email'               => 'El campo "Correo Electrónico" debe ser una dirección válida.',
            'email.max'                 => 'El campo "Correo Electrónico" no debe tener más de 255 caracteres.',

            'data.array'                => 'El campo "Datos" debe ser un arreglo.',
        ];
    }
}
