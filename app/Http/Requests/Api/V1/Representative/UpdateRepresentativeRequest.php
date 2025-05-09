<?php

namespace App\Http\Requests\Api\V1\Representative;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRepresentativeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('representative');

        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|digits_between:7,15',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'document_type' => 'required|string',
            'document_number' => 'required|string|unique:users,document_number,' . $id,
        ];
    }
}

