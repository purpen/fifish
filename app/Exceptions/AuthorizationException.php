<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthorizationException extends HttpException
{
    // HttpException参数顺序与Exception不同
    // __construct($statusCode, $message = null, \Exception $previous = null, array $headers = array(), $code = 0)
}