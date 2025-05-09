<?php

namespace App\Http\Requests\ExamResult;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamResultRequest extends FormRequest
{
    public function rules()
    {
        return [
            'exam_order_id' => 'required|exists:exam_orders,id',
            'created_by_user_id' => 'required|exists:users,id',
            'results' => 'required',
            'resource_url' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'exam_order_id.required' => 'El campo del pedido de examen es obligatorio.',
            'exam_order_id.exists' => 'El pedido de examen seleccionado no existe.',
            'created_by_user_id.required' => 'El campo usuario creador es obligatorio.',
            'created_by_user_id.exists' => 'El usuario creador seleccionado no existe.',
            'results.required' => 'El campo resultados es obligatorio.',
            'resource_url.string' => 'El campo URL de recurso debe ser una cadena de texto.',
            'resource_url.max' => 'El campo URL de recurso no puede tener más de 500 caracteres.',
            'is_active.boolean' => 'El estado de actividad debe ser verdadero o falso.',
        ];
    }
}
