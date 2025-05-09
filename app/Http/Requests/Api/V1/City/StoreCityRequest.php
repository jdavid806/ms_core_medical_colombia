<?php

namespace App\Http\Requests\Api\V1\City;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
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
            'name' => 'required|string|max:50|unique:cities,name',
            'department_id' => 'required|exists:departments,id',
            'area_code' => 'required|string|max:50|unique:cities,area_code',
            'is_active' => 'boolean',
        ];
    }
}
