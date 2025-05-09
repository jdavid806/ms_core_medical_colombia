<?php

namespace App\Http\Requests\ExamCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255|unique:exam_categories,name,' . $this->route('exam_category'),
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'El campo nombre debe ser un texto válido.',
            'name.max' => 'El campo nombre no puede exceder los 255 caracteres.',
            'name.unique' => 'El nombre de la categoría ya está registrado.',
            'is_active.boolean' => 'El campo activo debe ser verdadero o falso.',
        ];
    }
}
