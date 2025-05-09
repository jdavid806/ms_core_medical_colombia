<?php

namespace App\Exceptions;

class MissingContactInformationException extends JsonResponseException
{
    protected $message = 'Se requiere al menos un método de contacto (teléfono o correo electrónico) para notificar al paciente.';
    protected $code = 422;
}
