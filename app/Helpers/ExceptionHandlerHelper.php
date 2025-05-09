<?php

namespace App\Helpers;

use App\Exceptions\JsonResponseException;
use Exception;
use Illuminate\Support\Facades\Log;

class ExceptionHandlerHelper
{


    public static function throwException(Exception $exception, array $customMessages = []): string
    {
        $messages = array_merge(config('exceptions'), $customMessages);
        $message = $messages[get_class($exception)] ?? $messages[Exception::class];

        Log::info('Exception thrown', ['message' => $exception->getMessage()]);

        throw new JsonResponseException($message, $exception->getCode() ?: 500);
    }
}
