<?php

namespace App\Exceptions;

class UserScheduleUnavailableException extends JsonResponseException
{
    protected $message = 'No hay disponibilidad para el médico en el horario indicado.';
    protected $code = 422;
}
