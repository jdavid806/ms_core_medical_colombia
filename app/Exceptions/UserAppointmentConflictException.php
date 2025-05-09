<?php

namespace App\Exceptions;

class UserAppointmentConflictException extends JsonResponseException
{
    protected $message = 'El médico ya tiene citas agendadas en este horario.';
    protected $code = 422;
}
