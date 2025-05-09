<?php

namespace App\Http\Requests\ExamOrder;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamOrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'exam_order_item_id' => 'required|integer',
            'exam_order_item_type' => 'required|string|in:exam_type,exam_category,exam_package',
            'patient_id' => 'required|exists:patients,id',
            'exam_order_state_id' => 'nullable|exists:exam_order_states,id',
            'doctor_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'exam_order_item_id.required' => 'El campo ID del ítem de la orden del examen es obligatorio.',
            'exam_order_item_id.integer' => 'El ID del ítem de la orden del examen debe ser un número entero.',
            'exam_order_item_type.required' => 'El campo tipo de ítem de la orden del examen es obligatorio.',
            'exam_order_item_type.string' => 'El tipo de ítem de la orden del examen debe ser una cadena de texto.',
            'patient_id.required' => 'El campo paciente es obligatorio.',
            'patient_id.exists' => 'El paciente seleccionado no existe.',
            'exam_order_state_id.required' => 'El estado de la orden del examen es obligatorio.',
            'exam_order_state_id.in' => 'El estado de la orden debe ser "generated".',
            'doctor_id.exists' => 'El doctor seleccionado no existe.',
            'is_active.boolean' => 'El estado de actividad debe ser verdadero o falso.',
        ];
    }
}
