<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class AdmissionException extends Exception
{
    public function __construct(
        string $message = 'Admission not found',
        int $code = Response::HTTP_NOT_FOUND,
        ?Exception $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }

    public function render($request)
    {
        if($request->isJson())
        {
            return response()->json([
                'message' => $this->getMessage()
            ], $this->code);
        }
    }
}
