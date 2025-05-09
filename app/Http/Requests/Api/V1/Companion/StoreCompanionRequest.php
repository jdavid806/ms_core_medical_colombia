<?php

namespace App\Http\Requests\Api\V1\Companion;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanionRequest extends FormRequest
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
            'document_type' => 'required|in:CC,CE,TI',
            'document_number' => 'required|string|max:20|unique:companions,document_number',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|max:100|unique:companions',
            'is_active' => 'boolean',
        ];

        
    }
}
