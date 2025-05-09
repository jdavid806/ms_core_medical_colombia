<?php

namespace App\Http\Requests\ExamPackage;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamPackageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:exam_packages,name',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'name.unique' => 'Ya existe un paquete de examen con este nombre.',
            'is_active.boolean' => 'El estado de actividad debe ser verdadero o falso.',
        ];
    }
}
