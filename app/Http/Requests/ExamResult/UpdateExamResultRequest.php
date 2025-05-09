<?php

namespace App\Http\Requests\ExamResult;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamResultRequest extends FormRequest
{
    public function rules()
    {
        return [
            'exam_order_id' => 'sometimes|exists:exam_orders,id',
            'created_by_user_id' => 'sometimes|exists:users,id',
            'results' => 'sometimes',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages()
    {
        return [
            'exam_order_id.exists' => 'El pedido de examen seleccionado no existe.',
            'created_by_user_id.exists' => 'El usuario creador seleccionado no existe.',
            'is_active.boolean' => 'El estado de actividad debe ser verdadero o falso.',
        ];
    }
}
