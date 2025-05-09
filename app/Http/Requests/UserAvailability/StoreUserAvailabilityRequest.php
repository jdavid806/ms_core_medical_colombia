<?php

namespace App\Http\Requests\UserAvailability;

use App\Rules\UserAvailabilityFreeSlotsRule;
use App\Rules\UserAvailabilityNoOverlapRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserAvailabilityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'branch_id' => 'nullable|exists:branches,id',
            'appointment_duration' => 'required|integer|min:1',
            'days_of_week' => 'required|array',
            'days_of_week.*' => 'integer|between:0,6',
            'start_time' => [
                'required',
                'date_format:H:i:s',
                'before:end_time',
                new UserAvailabilityNoOverlapRule(
                    $this->input('start_time'),
                    $this->input('end_time'),
                    $this->input('days_of_week'),
                    $this->route('user')
                )
            ],
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'is_active' => 'nullable|boolean',
            'free_slots' => [
                'nullable',
                'array',
                new UserAvailabilityFreeSlotsRule(
                    $this->input('start_time'),
                    $this->input('end_time')
                )
            ],
            'office' => 'nullable|string',
            'module_id' => 'nullable|exists:modules,id',
            'free_slots.*.start_time' => 'required_with:free_slots|date_format:H:i:s|before:free_slots.*.end_time',
            'free_slots.*.end_time' => 'required_with:free_slots|date_format:H:i:s|after:free_slots.*.start_time',
        ];
    }

    public function messages()
    {
        return [
            'appointment_type_id.required' => 'El tipo de cita es obligatorio.',
            'appointment_type_id.exists' => 'El tipo de cita seleccionado no existe.',
            'branch_id.exists' => 'La sucursal seleccionada no existe.',
            'appointment_duration.required' => 'La duración de la cita es obligatoria.',
            'appointment_duration.integer' => 'La duración de la cita debe ser un número entero.',
            'appointment_duration.min' => 'La duración de la cita debe ser al menos 1 minuto.',
            'days_of_week.required' => 'Los días de la semana son obligatorios.',
            'days_of_week.array' => 'Los días de la semana deben ser un array.',
            'days_of_week.*.integer' => 'Cada día de la semana debe ser un número entero.',
            'days_of_week.*.between' => 'Cada día de la semana debe estar entre 0 y 6.',
            'start_time.required' => 'El campo de hora de inicio es obligatorio.',
            'start_time.date_format' => 'El formato de la hora de inicio no es válido. Use HH:mm:ss.',
            'start_time.before' => 'La hora de inicio debe ser anterior a la hora de finalización.',
            'end_time.required' => 'El campo de hora de finalización es obligatorio.',
            'end_time.date_format' => 'El formato de la hora de finalización no es válido. Use HH:mm:ss.',
            'end_time.after' => 'La hora de finalización debe ser posterior a la hora de inicio.',
            'is_active.boolean' => 'El valor de "activo" debe ser verdadero o falso.',
            'free_slots.array' => 'Los espacios libres deben ser un array.',
            'free_slots.*.start_time.required_with' => 'La hora de inicio del espacio libre es obligatoria.',
            'free_slots.*.start_time.date_format' => 'El formato de la hora de inicio del espacio libre no es válido. Use HH:mm:ss.',
            'free_slots.*.start_time.before' => 'La hora de inicio del espacio libre debe ser anterior a la hora de finalización.',
            'free_slots.*.end_time.required_with' => 'La hora de finalización del espacio libre es obligatoria.',
            'free_slots.*.end_time.date_format' => 'El formato de la hora de finalización del espacio libre no es válido. Use HH:mm:ss.',
            'free_slots.*.end_time.after' => 'La hora de finalización del espacio libre debe ser posterior a la hora de inicio.',
        ];
    }
}
