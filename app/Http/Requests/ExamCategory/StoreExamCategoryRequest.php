<?php

namespace App\Http\Requests\ExamCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:exam_categories,name',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser un texto válido.',
            'name.max' => 'El campo nombre no puede exceder los 255 caracteres.',
            'name.unique' => 'El nombre de la categoría ya está registrado.',
            'is_active.boolean' => 'El campo activo debe ser verdadero o falso.',
        ];
    }
}
