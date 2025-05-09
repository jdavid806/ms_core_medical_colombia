<?php

namespace App\Http\Requests\Admission;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdmissionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'external_id' => 'required|string|max:255',

            'admission' => 'required|array',
            'admission.authorization_number' => 'nullable|string|max:255',
            'admission.authorization_date' => 'nullable|date',
            'admission.appointment_id' => 'required|integer',
            'admission.debit_note_id' => 'nullable|integer',
            'admission.credit_note_id' => 'nullable|integer',
            'admission.new_invoice_id' => 'nullable|integer',
            'admission.copayment' => 'nullable|boolean',
            'admission.moderator_fee' => 'nullable|boolean',

            // Validaciones para "invoice"
            'invoice' => 'required|array',
            'invoice.due_date' => 'required|date',
            'invoice.observations' => 'nullable|string|max:255',

            // Validaciones para "invoice_detail"
            'invoice_detail' => 'required|array|min:1',
            'invoice_detail.*.product_id' => 'required|integer',
            'invoice_detail.*.quantity' => 'required|integer|min:1',
            'invoice_detail.*.unit_price' => 'required|numeric|min:0',
            'invoice_detail.*.discount' => 'nullable|numeric|min:0|max:100',

            // Validaciones para "payments"
            'payments' => 'required|array|min:1',
            'payments.*.payment_method_id' => 'required|integer',
            'payments.*.payment_date' => 'required|date',
            'payments.*.amount' => 'required|numeric|min:0',
            'payments.*.notes' => 'nullable|string|max:255',
        ];
    }



    public function messages()
    {
        return [
            'user_id.required' => 'El campo user_id es obligatorio.',
            'admission_type_id.required' => 'El campo admission_type_id es obligatorio.',
            'authorization_number.string' => 'El campo authorization_number debe ser una cadena de texto.',
            'authorization_date.date' => 'El campo authorization_date debe ser una fecha válida.',
            'appointment_id.required' => 'El campo appointment_id es obligatorio.',
            'invoice_id.required' => 'El campo invoice_id es obligatorio.',
            'debit_note_id.integer' => 'El campo debit_note_id debe ser un número entero.',
            'credit_note_id.integer' => 'El campo credit_note_id debe ser un número entero.',
            'new_invoice_id.integer' => 'El campo new_invoice_id debe ser un número entero.',
            'copayment.boolean' => 'El campo copayment debe ser un valor booleano.',
            'moderator_fee.boolean' => 'El campo moderator_fee debe ser un valor booleano.'
        ];
    }
}
