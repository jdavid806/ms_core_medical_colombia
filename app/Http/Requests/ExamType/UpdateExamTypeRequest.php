<?php

namespace App\Http\Requests\ExamType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255|unique:exam_types,name,' . $this->route('exam_type'),
            'description' => 'nullable|string',
            'form_config' => 'sometimes',
            'type' => 'sometimes|string',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'El campo nombre debe ser un texto válido.',
            'name.max' => 'El campo nombre no puede exceder los 255 caracteres.',
            'name.unique' => 'El nombre del tipo de examen ya está registrado.',
            'description.string' => 'El campo descripción debe ser un texto válido.',
            'type.string' => 'El campo tipo debe ser un texto valido.',
            'is_active.boolean' => 'El campo activo debe ser verdadero o falso.',
        ];
    }
}
