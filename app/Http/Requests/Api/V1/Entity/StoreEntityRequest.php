<?php

namespace App\Http\Requests\Api\V1\Entity;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntityRequest extends FormRequest
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
            'name' => 'required|string',
            'document_type' => 'required',
            'document_number' => 'required|integer|unique:entities,document_number',
            'email' => 'required|email|unique:entities',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city_id' => 'required|string',
            'tax_charge_id' => 'integer',
            'withholding_tax_id' => 'integer',
            'koneksi_sponsor_slug' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'document_number.unique' => 'The document number has already been taken.',
            'email.unique' => 'The email has already been taken.',
            'phone.unique' => 'The phone number has already been taken.',
            'city_id.required' => 'The city is required.',
            'koneksi_sponsor_slug.nullable' => 'The koneksi sponsor slug is string.',
        ];
    }
}
