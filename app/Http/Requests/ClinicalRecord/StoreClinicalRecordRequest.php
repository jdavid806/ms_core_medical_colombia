<?php

namespace App\Http\Requests\ClinicalRecord;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicalRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'clinical_record_type_id' => 'required|exists:clinical_record_types,id',
            'created_by_user_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'description' => 'nullable|string|max:500',
            'consultation_duration' => 'nullable|date_format:H:i',
            'data' => 'required',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'clinical_record_type_id.required' => 'El tipo de registro clínico es obligatorio.',
            'clinical_record_type_id.exists' => 'El tipo de registro clínico seleccionado no es válido.',
            'created_by_user_id.required' => 'El usuario creador es obligatorio.',
            'created_by_user_id.exists' => 'El usuario creador no es válido.',
            'branch_id.required' => 'La sucursal es obligatoria.',
            'branch_id.exists' => 'La sucursal seleccionada no es válida.',
            'description.string' => 'La descripción debe ser un texto válido.',
            'description.max' => 'La descripción no debe superar los 500 caracteres.',
            'data.required' => 'Los datos del registro clínico son obligatorios.',
            'is_active.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }
}
