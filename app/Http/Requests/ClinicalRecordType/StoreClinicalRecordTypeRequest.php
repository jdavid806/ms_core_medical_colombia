<?php

namespace App\Http\Requests\ClinicalRecordType;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicalRecordTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:clinical_record_types,name',
            'description' => 'nullable|string',
            'form_config' => 'required',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no debe superar los 255 caracteres.',
            'name.unique' => 'Ya existe un tipo de registro clínico con este nombre.',
            'description.string' => 'La descripción debe ser un texto válido.',
            'form_config.required' => 'La configuración del formulario es obligatoria.',
            'is_active.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }
}
