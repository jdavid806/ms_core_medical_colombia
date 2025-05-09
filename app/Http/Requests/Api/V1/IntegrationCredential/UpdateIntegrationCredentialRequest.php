<?php

namespace App\Http\Requests\Api\V1\IntegrationCredential;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIntegrationCredentialRequest extends FormRequest
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
}
