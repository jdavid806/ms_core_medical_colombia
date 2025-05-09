<?php

namespace App\Http\Requests\Api\V1\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'representatives' => 'array',
            'representatives.*.name' => 'required|string|max:255',
            'representatives.*.phone' => 'required|string|max:20',
            'representatives.*.email' => 'nullable|email|max:255',
            'representatives.*.document_type' => 'required|string|max:50',
            'representatives.*.document_number' => 'required|string|max:50',
            'offices' => 'array',
            'offices.*.commercial_name' => 'required|string|max:255',
            'offices.*.name' => 'required|string|max:255',
            'offices.*.document_type' => 'required|string|max:50',
            'offices.*.document_number' => 'required|string|max:50',
            'billing' => 'required|array',
            'billing.dian_prefix' => 'required|string|max:10',
            'billing.resolution_number' => 'required|string|max:50',
            'billing.invoice_from' => 'required|integer',
            'billing.invoice_to' => 'required|integer',
            'billing.resolution_date' => 'required|date',
            'billing.expiration_date' => 'required|date',
            'contacts' => 'array',
            'contacts.*.type' => 'required|string|max:50',
            'contacts.*.value' => 'required|string|max:255',
            'contacts.*.country' => 'required|string|max:100',
            'contacts.*.city' => 'required|string|max:100',
            'communication' => 'required|array',
            'communication.smtp_server' => 'required|string|max:255',
            'communication.port' => 'required|integer',
            'communication.security' => 'required|string|max:10',
            'communication.email' => 'required|email|max:255',
            'communication.password' => 'required|string|max:255',
            'communication.api_key' => 'required|string|max:255',
            'communication.instance' => 'required|string|max:255',
            'branches' => 'array',
            'branches.*.name' => 'required|string|max:255',
            'branches.*.email' => 'required|email|max:255',
            'branches.*.whatsapp' => 'required|string|max:20',
            'branches.*.address' => 'required|string|max:255',
            'branches.*.city' => 'required|string|max:100',
            'branches.*.state' => 'required|string|max:100',
            'branches.*.country' => 'required|string|max:100',
            'branches.*.representatives' => 'array',
            'branches.*.representatives.*.name' => 'required|string|max:255',
            'branches.*.representatives.*.phone' => 'required|string|max:20',
        ];
    }
}
