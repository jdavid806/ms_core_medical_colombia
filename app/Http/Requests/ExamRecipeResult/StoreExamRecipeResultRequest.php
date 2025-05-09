<?php

namespace App\Http\Requests\ExamRecipeResult;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamRecipeResultRequest extends FormRequest
{
    public function rules()
    {
        return [
            'exam_recipe_id' => 'required|exists:exam_recipes,id',
            'uploaded_by_user_id' => 'required|exists:users,id',
            'result_minio_id' => 'nullable|string|max:500',
            'date' => 'nullable|date',
            'comment' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'exam_recipe_id.required' => 'El campo receta de examen es obligatorio.',
            'exam_recipe_id.exists' => 'La receta de examen seleccionada no existe.',
            'uploaded_by_user_id.required' => 'El campo usuario que sube es obligatorio.',
            'uploaded_by_user_id.exists' => 'El usuario que sube seleccionado no existe.',
            'result_minio_id.string' => 'El campo ID de Minio del resultado debe ser una cadena de texto.',
            'result_minio_id.max' => 'El campo ID de Minio del resultado no puede tener más de 500 caracteres.',
            'date.date' => 'El campo fecha debe ser una fecha válida.',
            'comment.string' => 'El campo comentario debe ser una cadena de texto.',
        ];
    }
}
