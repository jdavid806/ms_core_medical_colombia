<?php

namespace App\Http\Requests\Branch;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
{
    public function authorize()
    {
        // Agrega aquí la lógica de autorización si es necesario
        return true;
    }

    public function rules()
    {
        return [
            // Con 'sometimes' validamos solo si se envía el campo
            'city_id'  => 'sometimes|exists:cities,id',
            'address'  => 'sometimes|string|max:255',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages()
    {
        return [
            'city_id.exists'     => 'La ciudad seleccionada no existe.',
            'address.string'     => 'El campo dirección debe ser una cadena de caracteres.',
            'address.max'        => 'El campo dirección no debe exceder los 255 caracteres.',
            'is_active.boolean'  => 'El campo activo debe ser verdadero o falso.',
        ];
    }
}
