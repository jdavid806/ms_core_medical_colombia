<?php

namespace App\Exceptions;

use Exception;

class JsonResponseException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = null)
    {
        if ($message) {
            $this->message = $message;
        }
        parent::__construct($this->message, $this->code);
    }

    public function render($request)
    {
        $response = [
            'error' => $this->getMessage()
        ];

        if (app()->environment('local')) {
            $response['trace'] = $this->getTrace();
        }

        return response()->json($response, $this->getCode() ?: 400);
    }
}
