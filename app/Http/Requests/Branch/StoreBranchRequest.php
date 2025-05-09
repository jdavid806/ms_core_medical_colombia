<?php

namespace App\Http\Requests\Branch;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
{
    public function authorize()
    {
        // Aquí puedes agregar lógica de autorización, por defecto se permite
        return true;
    }

    public function rules()
    {
        return [
            'city_id'  => 'required|exists:cities,id',
            'address'  => 'required|string|max:255',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages()
    {
        return [
            'city_id.required'   => 'El campo ciudad es obligatorio.',
            'city_id.exists'     => 'La ciudad seleccionada no existe.',
            'address.required'   => 'El campo dirección es obligatorio.',
            'address.string'     => 'El campo dirección debe ser una cadena de caracteres.',
            'address.max'        => 'El campo dirección no debe exceder los 255 caracteres.',
            'is_active.boolean'  => 'El campo activo debe ser verdadero o falso.',
        ];
    }
}
