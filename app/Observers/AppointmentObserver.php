<?php

namespace App\Observers;

use App\Jobs\SendSurveyJob;
use App\Models\Appointment;
use App\Jobs\PatientEducatorJob;
use App\Models\AppointmentState;
use App\Jobs\PostConsultationJob;
use App\Models\AppointmentStateHistory;
use App\Jobs\SendAppointmentToWebhookJob;
use App\Events\WaitingRoom\AppointmentStateUpdated;
use App\Jobs\AppointmentConfirmationAdvancePaymentJob;

class AppointmentObserver
{
    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "updated" event.
     */
    public function updated(Appointment $appointment): void
    {

        // Verificar si cambió el estado
        if ($appointment->isDirty('appointment_state_id')) {
            AppointmentStateHistory::create([
                'appointment_id' => $appointment->id,
                'appointment_state_id' => $appointment->appointment_state_id,
                'change_date' => now(),
                'is_active' => true
            ]);
            AppointmentStateUpdated::dispatch(
                $appointment->id,
                app('X-Domain-Global'),
                $appointment->appointment_state_id
            );
        }

        if ($appointment->isDirty('appointment_state_id')) {
            $newState = AppointmentState::find($appointment->appointment_state_id);

            if ($newState && $newState->name === 'consultation_completed') {
                PostConsultationJob::dispatch($appointment->id);
                PatientEducatorJob::dispatch($appointment->id);
                SendAppointmentToWebhookJob::dispatch($appointment->id)->delay(now()->addMinutes(20));
                SendSurveyJob::dispatch($appointment->id)->delay(now()->addMinutes(5));
            }
        }

        if ($appointment->isDirty('appointment_state_id')) {
            $newState = AppointmentState::find($appointment->appointment_state_id);

            if ($newState && $newState->name === 'pending') {
                AppointmentConfirmationAdvancePaymentJob::dispatch($appointment->id);
            }
        }

    }

    /**
     * Handle the Appointment "deleted" event.
     */
    public function deleted(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "restored" event.
     */
    public function restored(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "force deleted" event.
     */
    public function forceDeleted(Appointment $appointment): void
    {
        //
    }
}
