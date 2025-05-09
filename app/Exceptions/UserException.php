<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UserException extends Exception
{
    public function __construct(
        string $message = 'User error occurred',
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function render($request)
    {
        if ($request->isJson()) {
            return response()->json([
                'message' => $this->getMessage(),
            ], $this->code);
        }
    }
}