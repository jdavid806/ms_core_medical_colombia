<?php

namespace App\Http\Requests\ExamOrder;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamOrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'exam_type_id' => 'sometimes|exists:exam_types,id',
            'patient_id' => 'sometimes|exists:patients,id',
            'exam_order_state_id' => 'sometimes|exists:exam_order_states,id',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages()
    {
        return [
            'exam_type_id.exists' => 'El tipo de examen seleccionado no existe.',
            'patient_id.exists' => 'El paciente seleccionado no existe.',
            'exam_order_state_id.exists' => 'El estado de la orden de examen seleccionado no existe.',
            'is_active.boolean' => 'El estado de actividad debe ser verdadero o falso.',
        ];
    }
}
