<?php

namespace App\Http\Requests\ClinicalEvolutionNote;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicalEvolutionNoteRequest extends FormRequest
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
            'create_by_user_id' => 'sometimes|exists:users,id',
            'note' => 'sometimes|string',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'create_by_user_id.exists' => 'El usuario creador seleccionado no es válido.',
            'note.string' => 'La nota debe ser un texto válido.',
            'is_active.boolean' => 'El estado de la nota debe ser verdadero o falso.',
        ];
    }
}
