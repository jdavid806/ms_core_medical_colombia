<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManyToManyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'children_ids' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'children_ids.required' => 'Se requieren los IDs hijos',
            'children_ids.array' => 'Los IDs hijos deben ser un arreglo',
        ];
    }
}
