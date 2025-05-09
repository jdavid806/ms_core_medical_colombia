<?php

namespace App\Http\Requests\ClinicalRecord;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicalRecordParams extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // ClinicalRecord
            'clinical_record_type_id' => 'required|exists:clinical_record_types,id',
            'created_by_user_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'consultation_duration' => 'nullable',
            'description' => 'nullable|string|max:500',
            'data' => 'required',
            'is_active' => 'boolean',

            // ExamOrder (anidado, no obligatorio)
            'exam_order' => 'nullable|array',
            'exam_order.*.exam_order_item_id' => 'sometimes|required|integer',
            'exam_order.*.exam_order_item_type' => 'sometimes|required|string|in:exam_type,exam_category,exam_package',
            'exam_order.*.patient_id' => 'sometimes|required|exists:patients,id',
            'exam_order.*.exam_order_state_id' => 'sometimes|required|exists:exam_order_states,id',
            'exam_order.*.is_active' => 'sometimes|boolean',

            // PatientDisability (anidado, no obligatorio)
            'patient_disability' => 'nullable|array',
            'patient_disability.user_id' => 'sometimes|required|exists:users,id',
            'patient_disability.start_date' => 'sometimes|required|date',
            'patient_disability.end_date' => 'sometimes|required|date|after_or_equal:patient_disability.start_date',
            'patient_disability.reason' => 'sometimes|required|string|max:500',
            'patient_disability.is_active' => 'sometimes|boolean',

            // Recipe (anidado, no obligatorio)
            'recipe' => 'nullable|array',
            'recipe.patient_id' => 'sometimes|required|integer',
            'recipe.user_id' => 'sometimes|required|integer',
            'recipe.type' => 'sometimes|required|string|in:general,optometry',
            'recipe.is_active' => 'sometimes|boolean',
            'recipe.medicines' => 'sometimes|required|array',
            'recipe.medicines.*.medication' => 'sometimes|required|string',
            'recipe.medicines.*.concentration' => 'sometimes|required|string',
            'recipe.medicines.*.frequency' => 'sometimes|required|string',
            'recipe.medicines.*.duration' => 'sometimes|required|integer',
            'recipe.medicines.*.medication_type' => 'sometimes|required|string',
            'recipe.medicines.*.take_every_hours' => 'sometimes|required|integer',
            'recipe.medicines.*.quantity' => 'sometimes|required|integer',
            'recipe.medicines.*.observations' => 'nullable|string',

            // Remission (anidado, no obligatorio)
            'remission' => 'nullable|array',
            'remission.receiver_user_id' => 'sometimes|nullable|exists:users,id',
            'remission.remitter_user_id' => 'sometimes|nullable|exists:users,id',
            'remission.receiver_user_specialty_id' => 'sometimes|nullable|exists:user_specialties,id',
            'remission.note' => 'sometimes|required|string',
            'remission.is_active' => 'sometimes|nullable|boolean',

            // VaccineApplication (anidado, no obligatorio)
            'evolution_note' => 'nullable|array',
            'evolution_note.create_by_user_id',
            'evolution_note.note',


            //exam_recipes
            'exam_recipes' => 'nullable|array',
            'exam_recipes.user_id' => 'sometimes|nullable|exists:users,id',

            //vaccine_application
            'vaccine_application' => 'nullable|array',
            'vaccine_application.group_vaccine_id' => 'sometimes|required|exists:group_vaccines,id',
            'vaccine_application.applied_by_user_id' => 'sometimes|required|exists:users,id',
            'vaccine_application.dose_number' => 'sometimes|required|integer',
            'vaccine_application.is_booster' => 'sometimes|boolean',
            'vaccine_application.description' => 'sometimes|nullable|string|max:500',
            'vaccine_application.application_date' => 'sometimes|required|date',
            'next_application_date' => 'sometimes|required|date|after_or_equal:vaccine_application.application_date',
            'vaccine_application.is_active' => 'sometimes|boolean',
        ];
    }
}
