<?php

namespace App\Http\Requests\ClinicalEvolutionNote;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicalEvolutionNoteRequest extends FormRequest
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
            'create_by_user_id' => 'required|exists:users,id',
            'note' => 'required|string',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'create_by_user_id.required' => 'El ID del usuario creador es obligatorio.',
            'create_by_user_id.exists' => 'El usuario creador seleccionado no es válido.',
            'note.required' => 'La nota es obligatoria.',
            'note.string' => 'La nota debe ser un texto válido.',
            'is_active.boolean' => 'El estado de la nota debe ser verdadero o falso.',
        ];
    }
}
