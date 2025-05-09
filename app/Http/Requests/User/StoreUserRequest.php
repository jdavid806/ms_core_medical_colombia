<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        // Ajusta la lógica de autorización según tus necesidades.
        return true;
    }

    public function rules()
    {
        return [
            'first_name'         => 'required|string|max:255',
            'middle_name'        => 'nullable|string|max:255',
            'last_name'          => 'required|string|max:255',
            'second_last_name'   => 'nullable|string|max:255',
            'external_id'        => 'required|string|max:255',
            'user_role_id'       => 'required|integer|exists:user_roles,id',
            'user_specialty_id'  => 'nullable|integer|exists:user_specialties,id',
            'is_active'          => 'nullable|boolean',
            'country_id'         => 'required|integer|exists:countries,id',
            'city_id'            => 'required|integer|exists:cities,id',
            'gender'             => 'required|in:MALE,FEMALE,INDETERMINATE,OTHER',
            'address'            => 'required|string',
            'phone'              => 'required|string|max:20',
            'email'              => 'required|email|max:255|unique:users,email',
            'data'               => 'nullable|array',
            'minio_id'           => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required'       => 'El campo "Nombre" es obligatorio.',
            'first_name.string'         => 'El campo "Nombre" debe ser un texto.',
            'first_name.max'            => 'El campo "Nombre" no debe tener más de 255 caracteres.',

            'middle_name.string'        => 'El campo "Segundo Nombre" debe ser un texto.',
            'middle_name.max'           => 'El campo "Segundo Nombre" no debe tener más de 255 caracteres.',

            'last_name.required'        => 'El campo "Apellido" es obligatorio.',
            'last_name.string'          => 'El campo "Apellido" debe ser un texto.',
            'last_name.max'             => 'El campo "Apellido" no debe tener más de 255 caracteres.',

            'second_last_name.string'   => 'El campo "Segundo Apellido" debe ser un texto.',
            'second_last_name.max'      => 'El campo "Segundo Apellido" no debe tener más de 255 caracteres.',

            'external_id.required'      => 'El campo "Identificador Externo" es obligatorio.',
            'external_id.string'        => 'El campo "Identificador Externo" debe ser un texto.',
            'external_id.max'           => 'El campo "Identificador Externo" no debe tener más de 255 caracteres.',

            'user_role_id.required'     => 'El campo "Rol de Usuario" es obligatorio.',
            'user_role_id.integer'      => 'El campo "Rol de Usuario" debe ser un número entero.',
            'user_role_id.exists'       => 'El rol de usuario seleccionado no existe.',

            'user_specialty_id.integer' => 'El campo "Especialidad de Usuario" debe ser un número entero.',
            'user_specialty_id.exists'  => 'La especialidad de usuario seleccionada no existe.',

            'is_active.boolean'         => 'El campo "Activo" debe ser verdadero o falso.',

            'country_id.required'       => 'El campo "País" es obligatorio.',
            'country_id.integer'        => 'El campo "País" debe ser un número entero.',
            'country_id.exists'         => 'El país seleccionado no existe.',

            'city_id.required'          => 'El campo "Ciudad" es obligatorio.',
            'city_id.integer'           => 'El campo "Ciudad" debe ser un número entero.',
            'city_id.exists'            => 'La ciudad seleccionada no existe.',

            'gender.required'           => 'El campo "Género" es obligatorio.',
            'gender.in'                 => 'El campo "Género" debe ser MALE, FEMALE, INDETERMINATE u OTHER.',

            'address.required'          => 'El campo "Dirección" es obligatorio.',
            'address.string'            => 'El campo "Dirección" debe ser un texto.',

            'phone.required'            => 'El campo "Teléfono" es obligatorio.',
            'phone.string'              => 'El campo "Teléfono" debe ser un texto.',
            'phone.max'                 => 'El campo "Teléfono" no debe tener más de 20 caracteres.',

            'email.required'            => 'El campo "Correo Electrónico" es obligatorio.',
            'email.email'               => 'El campo "Correo Electrónico" debe ser una dirección válida.',
            'email.max'                 => 'El campo "Correo Electrónico" no debe tener más de 255 caracteres.',
            'email.unique'              => 'El correo electrónico ya ha sido registrado.',

            'data.array'                => 'El campo "Datos" debe ser un arreglo.',
        ];
    }
}
