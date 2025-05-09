<?php

namespace App\Http\Requests\NursingNote;

use Illuminate\Foundation\Http\FormRequest;

class StoreNursingNoteRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'note' => 'required|string|max:65535',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => 'El médico es obligatorio.',
            'user_id.exists' => 'El médico seleccionado no existe en el sistema.',
            'note.required' => 'La nota es obligatoria.',
            'note.string' => 'La nota debe ser un texto válido.',
            'note.max' => 'La nota no puede superar los 65535 caracteres.',
            'is_active.boolean' => 'El campo estado debe ser un valor booleano.',
        ];
    }
}
