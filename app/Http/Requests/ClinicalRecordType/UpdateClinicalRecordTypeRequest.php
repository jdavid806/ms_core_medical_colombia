<?php

namespace App\Http\Requests\ClinicalRecordType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicalRecordTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255|unique:clinical_record_types,name,' . $this->route('clinical_record_type'),
            'description' => 'sometimes|nullable|string',
            'form_config' => 'sometimes',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no debe superar los 255 caracteres.',
            'name.unique' => 'Ya existe un tipo de registro clínico con este nombre.',
            'description.string' => 'La descripción debe ser un texto válido.',
            'is_active.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }
}
