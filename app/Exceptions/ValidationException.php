<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    public function __construct($message, $code = 422)
    {
        parent::__construct($message, 422);
    }

    public function render()
    {
        return response(['error' => 'VALIDATION ERROR 422'], 422);
    }
}
