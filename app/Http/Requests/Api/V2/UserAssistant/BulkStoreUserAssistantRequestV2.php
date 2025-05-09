<?php

namespace App\Http\Requests\Api\V2\UserAssistant;

use Illuminate\Foundation\Http\FormRequest;

class BulkStoreUserAssistantRequestV2 extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supervisor_user_id' => 'required|exists:users,id',
            'assistants' => 'required|array|min:1'
        ];
    }

    public function messages()
    {
        return [
            'supervisor_user_id.required' => 'El ID del supervisor es requerido.',
            'assistants.required' => 'El campo asistentes es requerido.',
            'assistants.array' => 'El campo asistentes debe ser un array.',
            'assistants.min' => 'Debe enviar al menos un asistente.'
        ];
    }
}
