<?php

namespace App\Http\Requests\ExamOrderState;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamOrderStateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|in:pending,canceled,uploaded,generated|unique:exam_order_states,name,' . $this->route('exam_order_state'),
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.in' => 'El valor del nombre debe ser uno de los siguientes: pending, canceled, uploaded, generated.',
            'name.unique' => 'El estado del pedido de examen con este nombre ya existe.',
            'is_active.boolean' => 'El estado de actividad debe ser verdadero o falso.',
        ];
    }
}
