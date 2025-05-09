<?php

namespace App\Http\Requests\Remission;

use Illuminate\Foundation\Http\FormRequest;

class StoreRemissionRequest extends FormRequest
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
            'receiver_user_id' => 'required|exists:users,id',
            'remitter_user_id' => 'nullable|exists:users,id',
            'clinical_record_id' => 'required|exists:clinical_records,id',
            'receiver_user_specialty_id' => 'nullable|exists:user_specialties,id',
            'note' => 'required|string',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'receiver_user_id.exists' => 'El usuario receptor seleccionado no es válido.',
            'remitter_user_id.required' => 'El ID del usuario remitente es obligatorio.',
            'remitter_user_id.exists' => 'El usuario remitente seleccionado no es válido.',
            'clinical_record_id.required' => 'El ID de la historia clínica es obligatorio.',
            'clinical_record_id.exists' => 'La historia clinica seleccionada no es valida.',
            'receiver_user_specialty_id.exists' => 'La especialidad seleccionada no es valida.',
            'note.required' => 'La nota es obligatoria.',
            'note.string' => 'La nota debe ser un texto válido.',
        ];
    }
}
