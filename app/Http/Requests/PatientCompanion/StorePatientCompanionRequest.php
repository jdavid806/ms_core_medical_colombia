<?php

namespace App\Http\Requests\PatientCompanion;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientCompanionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'companions' => 'required|array',
            'companions.*.companion_id' => 'required|exists:companions,id',
            'companions.*.relationship_id' => 'required|exists:relationships,id'
        ];
    }

    /* public function messages()
    {
        return [
            'first_name.required'   => 'El campo nombre es obligatorio.',
            'first_name.string'     => 'El campo nombre debe ser una cadena de texto.',
            'first_name.max'        => 'El campo nombre no puede tener más de 100 caracteres.',
            'last_name.required'    => 'El campo apellido es obligatorio.',
            'last_name.string'      => 'El campo apellido debe ser una cadena de texto.',
            'last_name.max'         => 'El campo apellido no puede tener más de 100 caracteres.',
            'relationship.string'   => 'El campo relación debe ser una cadena de texto.',
            'relationship.max'      => 'El campo relación no puede tener más de 50 caracteres.',
            'phone.string'          => 'El campo teléfono debe ser una cadena de texto.',
            'phone.max'             => 'El campo teléfono no puede tener más de 20 caracteres.',
            'email.email'           => 'El campo correo electrónico debe ser una dirección de correo válida.',
            'email.max'             => 'El campo correo electrónico no puede tener más de 100 caracteres.',
        ];
    } */
}
