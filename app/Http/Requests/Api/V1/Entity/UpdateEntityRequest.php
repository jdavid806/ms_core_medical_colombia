<?php

namespace App\Http\Requests\Api\V1\Entity;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEntityRequest extends FormRequest
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
        $entityId = $this->route('entity'); // Asegúrate de pasar el ID de la entidad en la ruta

        return [
            'name' => 'required|string',
            'document_type' => 'required',
            'document_number' => [
                'required',
                'integer',
                Rule::unique('entities', 'document_number')->ignore($entityId),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('entities', 'email')->ignore($entityId),
            ],
            'phone' => 'required|string',
            'address' => 'required|string',
            'city_id' => 'required|string',
            'koneksi_sponsor_slug' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'document_number.unique' => 'The document number has already been taken.',
            'email.unique' => 'The email has already been taken.',
            'phone.required' => 'The phone number is required.',
            'address.required' => 'The address is required.',
            'city_id.required' => 'The city is required.',
            'keneksi_sponsor_slug.nullable' => 'The koneksi sponsor slug is string.',
        ];
    }
}
