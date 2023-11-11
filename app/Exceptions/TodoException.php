<?php

namespace App\Exceptions;

use Exception;

class TodoException extends Exception
{
    /**
     * Handles the case when the expected path variable is invalid
     * @return TodoException
     */
    public static function invalidPathVariableException(): TodoException
    {
        return new self(
            'Path variable type is invalid!',
            400
        );
    }

    /**
     * Handles the exception case when an item can't be found in the database.
     * @return TodoException
     */
    public static function itemNotFound(): TodoException
    {
        return new self(
            'Todo item was not found',
            404
        );
    }

    /**
     * Handles the case when the give body of TodoRequest is invalid
     * @return TodoException
     */
    public static function invalidRequestBody(): TodoException
    {
        return new self(
            'Request body is invalid! Fields or it\'s values are possibly incorrect!',
            400
        );
    }

    public static function invalidHtmlTagsInBody(): TodoException
    {
        return new self(
            'Invalid html tags found in request body!',
            400
        );
    }
}
