<?php

namespace App\Http\Requests\ExamOrderState;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamOrderStateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|in:pending,canceled,uploaded,generated|unique:exam_order_states,name',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.in' => 'El valor del nombre debe ser uno de los siguientes: pending, canceled, uploaded, generated.',
            'name.unique' => 'El estado del pedido de examen con este nombre ya existe.',
            'is_active.boolean' => 'El estado de actividad debe ser verdadero o falso.',
        ];
    }
}
