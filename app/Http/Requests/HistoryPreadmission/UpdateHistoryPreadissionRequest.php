<?php

namespace App\Http\Requests\HistoryPreadmission;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHistoryPreadmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'weight' => 'required|integer',
            'size' => 'required|integer',
            'glycemia' => 'required|integer',
            'patient_id' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'weight.required' => 'El peso es obligatorio.',
            'weight.integer' => 'El peso debe ser un numero válido.',

            'size.required' => 'La talla es obligatoria.',
            'size.integer' => 'La talla no es un numero valido.',

            'glycemia.required' => 'la glucemia es obligatoria.',
            'glycemia.integer' => 'La glucemia no es un numero valido.',

            'patient_id.required' => 'El paciente es obligatori.',
            'patient_id.integer' => 'El paciente no es valido.',

        ];
    }
}
