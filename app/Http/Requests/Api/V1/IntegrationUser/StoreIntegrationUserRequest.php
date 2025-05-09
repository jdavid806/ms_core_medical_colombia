<?php

namespace App\Http\Requests\Api\V1\IntegrationUser;

use Illuminate\Foundation\Http\FormRequest;

class StoreIntegrationUserRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'integration_id' => 'required|exists:integrations,id',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user ID does not exist.',
            'integration_id.required' => 'The integration ID is required.',
            'integration_id.exists' => 'The selected integration ID does not exist.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be either active or inactive.',
        ];
    }
    public function attributes(): array
    {
        return [
            'user_id' => 'user ID',
            'integration_id' => 'integration ID',
            'status' => 'status',
        ];
    }
}
