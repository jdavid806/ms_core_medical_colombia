<?php

namespace App\Http\Requests\UserAvailability;

use App\Rules\ConsistentTimeRule;
use App\Rules\UserAvailabilityFreeSlotsRule;
use App\Rules\UserAvailabilityNoOverlapRule;
use App\Services\UserAvailabilityService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAvailabilityRequest extends FormRequest
{
    public $userAvailabilityService;

    public function __construct(UserAvailabilityService $userAvailabilityService)
    {
        $this->userAvailabilityService = $userAvailabilityService;
    }

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
        $userAvailability = $this->userAvailabilityService->getById($this->route('availability'));
        $currentStartTime = $userAvailability->start_time;
        $currentEndTime = $userAvailability->end_time;
        $currentUser = $userAvailability->user_id;
        $currentDaysOfWeek = $userAvailability->days_of_week;
        $currentId = $userAvailability->id;

        $startTime = $this->input('start_time', $currentStartTime);
        $endTime = $this->input('end_time', $currentEndTime);
        $daysOfWeek = $this->input('days_of_week', $currentDaysOfWeek);
        $user = $this->route('user', $currentUser);

        return [
            'appointment_type_id' => 'sometimes|exists:appointment_types,id',
            'branch_id' => 'nullable|exists:branches,id',
            'appointment_duration' => 'sometimes|integer|min:1',
            'days_of_week' => 'sometimes|array',
            'days_of_week.*' => 'integer|between:0,6',
            'start_time' => [
                'sometimes',
                'date_format:H:i:s',
                'before:end_time',
                new ConsistentTimeRule($startTime, $endTime),
                new UserAvailabilityNoOverlapRule(
                    $startTime,
                    $endTime,
                    $daysOfWeek,
                    $user,
                    $currentId
                )
            ],
            'end_time' => [
                'sometimes',
                'date_format:H:i:s',
                'after:start_time',
                new ConsistentTimeRule($startTime, $endTime)
            ],
            'is_active' => 'nullable|boolean',
            'office' => 'nullable|string',
            'module_id' => 'nullable|exists:modules,id',
            'free_slots' => [
                'nullable',
                'array',
                new UserAvailabilityFreeSlotsRule(
                    $startTime,
                    $endTime
                )
            ],
            'free_slots.*.start_time' => 'required_with:free_slots|date_format:H:i:s|before:free_slots.*.end_time',
            'free_slots.*.end_time' => 'required_with:free_slots|date_format:H:i:s|after:free_slots.*.start_time',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'appointment_type_id.exists' => 'El tipo de cita seleccionado no existe.',
            'branch_id.exists' => 'La sucursal seleccionada no existe.',
            'appointment_duration.integer' => 'La duración de la cita debe ser un número entero.',
            'appointment_duration.min' => 'La duración de la cita debe ser al menos 1 minuto.',
            'days_of_week.array' => 'Los días de la semana deben ser un array.',
            'days_of_week.*.integer' => 'Cada día de la semana debe ser un número entero.',
            'days_of_week.*.between' => 'Cada día de la semana debe estar entre 0 y 6.',
            'start_time.date_format' => 'El formato de la hora de inicio no es válido. Use HH:mm:ss.',
            'start_time.before' => 'La hora de inicio debe ser anterior a la hora de finalización.',
            'end_time.date_format' => 'El formato de la hora de finalización no es válido. Use HH:mm:ss.',
            'end_time.after' => 'La hora de finalización debe ser posterior a la hora de inicio.',
            'is_active.boolean' => 'El valor de "activo" debe ser verdadero o falso.',
            'free_slots.array' => 'Los espacios libres deben ser un array.',
            'free_slots.*.start_time.sometimes_with' => 'La hora de inicio del espacio libre es obligatoria.',
            'free_slots.*.start_time.date_format' => 'El formato de la hora de inicio del espacio libre no es válido. Use HH:mm:ss.',
            'free_slots.*.start_time.before' => 'La hora de inicio del espacio libre debe ser anterior a la hora de finalización.',
            'free_slots.*.end_time.sometimes_with' => 'La hora de finalización del espacio libre es obligatoria.',
            'free_slots.*.end_time.date_format' => 'El formato de la hora de finalización del espacio libre no es válido. Use HH:mm:ss.',
            'free_slots.*.end_time.after' => 'La hora de finalización del espacio libre debe ser posterior a la hora de inicio.',
        ];
    }
}
