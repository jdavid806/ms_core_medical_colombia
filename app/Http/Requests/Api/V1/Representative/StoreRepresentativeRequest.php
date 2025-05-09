<?php

namespace App\Http\Requests\Api\V1\Representative;

use Illuminate\Foundation\Http\FormRequest;

class StoreRepresentativeRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => 'required|digits_between:7,15',
            'email' => 'required|email|max:255',
            'document_type' => 'required|string',
            'document_number' => 'required|string', // Cambia "users" por la tabla correspondiente
        ];
    }
}
