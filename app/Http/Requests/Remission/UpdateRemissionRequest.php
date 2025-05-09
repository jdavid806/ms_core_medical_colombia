<?php

namespace App\Http\Requests\Remmission;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRemissionRequest extends FormRequest
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
            'receiver_user_id' => 'sometimes|exists:users,id',
            'remitter_user_id' => 'sometimes|exists:users,id',
            'clinical_record_id' => 'sometimes|exists:clinical_records,id',
            'receiver_user_specialty_id' => 'sometimes|exists:user_specialties,id',
            'note' => 'sometimes|string',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'receiver_user_id.exists' => 'El usuario receptor seleccionado no es válido.',
            'remitter_user_id.exists' => 'El usuario remitente seleccionado no es válido.',
            'clinical_record_id.exists' => 'El historial clinico no es valido.',
            'receiver_user_specialty_id.exists' => 'La especialidad seleccionada no es valida.',
            'note.string' => 'La nota debe ser un texto válido.',
        ];
    }
}
