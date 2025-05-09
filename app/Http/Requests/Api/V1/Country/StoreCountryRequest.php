<?php

namespace App\Http\Requests\Api\V1\Country;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
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
            'name' => 'required|string|max:50|unique:countries,name',
            'country_code' => 'required|string|max:3|unique:countries,country_code',
            "phone_code" => 'required|string|max:3|unique:countries,phone_code',
            'is_active' => 'boolean',
        ];
    }
}
