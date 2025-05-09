<?php

namespace App\Http\Requests\Admission;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'admission_type_id' => 'sometimes|exists:admission_types,id',
            'is_active' => 'sometimes|boolean',
            'document_minio_id' => 'sometimes|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists' => 'El usuario seleccionado no es válido.',
            'admission_type_id.exists' => 'El tipo de admisión seleccionado no es válido.',
            'is_active.boolean' => 'El estado activo debe ser verdadero o falso.',
            'document_minio_id.string' => 'El ID del documento debe ser una cadena de texto.',
            'document_minio_id.max' => 'El ID del documento no puede exceder 255 caracteres.',
        ];
    }
}
