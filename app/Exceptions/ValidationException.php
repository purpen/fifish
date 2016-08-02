<?php

namespace App\Exceptions;

use Dingo\Api\Exception\ResourceException;

class ValidationException extends ResourceException
{
    /**
     * Create a new validation HTTP exception instance.
     *
     * @param \Illuminate\Support\MessageBag|array $errors
     * @param \Exception                           $previous
     * @param array                                $headers
     * @param int                                  $code
     *
     * @return void
     */
    public function __construct($message = null, $errors = null, Exception $previous = null, $headers = [], $code = 0)
    {
        parent::__construct($message, $errors, $previous, $headers, $code);
    }
}