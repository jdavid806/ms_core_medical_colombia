<?php

namespace App\Http\Requests\Api\V2\UserAssistant;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserAssistantRequestV2 extends FormRequest
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
            'supervisor_user_id' => 'nullable|exists:users,id',
            'assistant_user_id' => 'required|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'supervisor_user_id.exists' => 'El ID del supervisor no existe.',
            'assistant_user_id.required' => 'El ID del asistente es requerido.',
            'assistant_user_id.exists' => 'El ID del asistente no existe.',
        ];
    }
}
