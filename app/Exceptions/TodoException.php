<?php

namespace App\Exceptions;

use Exception;

class TodoException extends Exception
{
    public static function invalidPathVariableException(): TodoException
    {
        return new self(
            'Path variable type is invalid!',
            400
        );
    }

    public static function itemNotFound(): TodoException
    {
        return new self(
            'Todo item was not found',
            404
        );
    }

    public static function invalidRequestBody(): TodoException
    {
        return new self(
            'Request body is invalid! Fields or it\'s values are possibly incorrect!',
            404
        );
    }
}
