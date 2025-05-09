<?php

namespace App\Http\Requests\Api\V1\IntegrationCredential;

use Illuminate\Foundation\Http\FormRequest;

class StoreIntegrationCredentialRequest extends FormRequest
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
            'integration_id' => 'required|exists:integrations,id',
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'is_sensitive' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'integration_id.required' => 'The integration ID field is required.',
            'integration_id.exists' => 'The selected integration ID is invalid.',
            'key.required' => 'The key field is required.',
            'key.string' => 'The key must be a string.',
            'key.max' => 'The key may not be greater than 255 characters.',
            'value.required' => 'The value field is required.',
            'value.string' => 'The value must be a string.',
            'value.max' => 'The value may not be greater than 255 characters.',
            'is_sensitive.boolean' => 'The is sensitive field must be true or false.',
        ];
    }
    
    public function attributes(): array
    {
        return [
            'integration_id' => 'integration ID',
            'key' => 'integration credential key',
            'value' => 'integration credential value',
            'is_sensitive' => 'is sensitive',
        ];  
    }
}
