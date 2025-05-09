<?php

return [
    \Illuminate\Database\QueryException::class => 'Ha ocurrido un problema con nuestra base de datos. Por favor, intenta nuevamente más tarde.',
    \Illuminate\Database\Eloquent\ModelNotFoundException::class => 'El recurso solicitado no se encuentra disponible.',
    \Illuminate\Database\Eloquent\MassAssignmentException::class => 'Los datos enviados no son válidos para esta operación.',
    \Illuminate\Validation\ValidationException::class => 'Algunos campos no cumplen con los requisitos. Por favor, revisa e inténtalo nuevamente.',
    \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException::class => 'No tienes permisos para realizar esta acción.',
    \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class => 'La página o recurso solicitado no existe.',
    \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException::class => 'No estás autorizado para realizar esta acción.',
    \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException::class => 'El método utilizado para esta solicitud no está permitido.',
    \Exception::class => 'Ha ocurrido un error inesperado. Por favor, intenta nuevamente más tarde.',
];
