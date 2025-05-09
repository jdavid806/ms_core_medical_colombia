<?php

namespace App\Http\Requests\ExamType;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:exam_types,name',
            'description' => 'nullable|string',
            'form_config' => 'required',
            'type' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser un texto válido.',
            'name.max' => 'El campo nombre no puede exceder los 255 caracteres.',
            'name.unique' => 'El nombre del tipo de examen ya está registrado.',
            'description.string' => 'El campo descripción debe ser un texto válido.',
            'type.string' => 'El campo tipo debe ser un texto valido.',
            'form_config.required' => 'El campo configuración del formulario es obligatorio.',
            'is_active.boolean' => 'El campo activo debe ser verdadero o falso.',
        ];
    }
}
