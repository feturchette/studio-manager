<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    public function __construct($message, $code = 404)
    {
        parent::__construct($message, 404);
    }

    public function render()
    {
        return response(['error' => 'NOT FOUND 404'], 404);
    }
}
