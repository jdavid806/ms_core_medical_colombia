<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManyToManyPolymorphicRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
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
            'children' => 'required|array|min:1',
            'children.*.id' => 'required|integer',
            'children.*.type' => 'required|string'
        ];
    }

    /**
     * Mensajes de error personalizados.
     */
    public function messages(): array
    {
        return [
            'children.required' => 'El campo children es obligatorio.',
            'children.array' => 'El campo children debe ser un array.',
            'children.*.id.required' => 'El campo id es obligatorio para cada hijo.',
            'children.*.id.integer' => 'El campo id debe ser un número entero.',
            'children.*.type.required' => 'El campo type es obligatorio para cada hijo.',
            'children.*.type.string' => 'El campo type debe ser una cadena de texto.',
        ];
    }
}
