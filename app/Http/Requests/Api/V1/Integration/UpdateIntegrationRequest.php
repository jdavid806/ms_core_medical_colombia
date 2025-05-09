<?php

namespace App\Http\Requests\Api\V1\Integration;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIntegrationRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:integrations,name,' . $this->route('integration')->id,
            'type' => 'required|string|in:api,webhook',
            'status' => 'required|string',
            'url' => 'required|url',
            'auth_type' => 'required|string|in:none,basic,bearer',
            'auth_config' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'name.unique' => 'The name has already been taken.',
            'type.required' => 'The type field is required.',
            'type.string' => 'The type must be a string.',
            'type.in' => 'The selected type is invalid.',
            'status.required' => 'The status field is required.',
            'status.string' => 'The status must be a string.',
            'url.required' => 'The URL field is required.',
            'url.url' => 'The URL format is invalid.',
            'auth_type.required' => 'The auth type field is required.',
            'auth_type.string' => 'The auth type must be a string.',
            'auth_type.in' => 'The selected auth type is invalid.',
            'auth_config.array' => 'The auth config must be an array.',
        ];
    }
    public function attributes(): array
    {
        return [
            'name' => 'integration name',
            'type' => 'integration type',
            'status' => 'integration status',
            'url' => 'integration URL',
            'auth_type' => 'authentication type',
            'auth_config' => 'authentication configuration',
        ];
    }
}
