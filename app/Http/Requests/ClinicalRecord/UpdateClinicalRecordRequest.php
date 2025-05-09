<?php

namespace App\Http\Requests\ClinicalRecord;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicalRecordRequest extends FormRequest
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
            'clinical_record_type_id' => 'sometimes|exists:clinical_record_types,id',
            'created_by_user_id' => 'sometimes|exists:users,id',
            'branch_id' => 'sometimes|exists:branches,id',
            'description' => 'sometimes|nullable|string|max:500',
            'data' => 'sometimes',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages()
    {
        return [
            'clinical_record_type_id.exists' => 'El tipo de registro clínico seleccionado no es válido.',
            'created_by_user_id.exists' => 'El usuario creador no es válido.',
            'branch_id.exists' => 'La sucursal seleccionada no es válida.',
            'description.string' => 'La descripción debe ser un texto válido.',
            'description.max' => 'La descripción no debe superar los 500 caracteres.',
            'is_active.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }
}
