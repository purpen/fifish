<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NotFoundException extends HttpException
{
    // 参数顺序与Exception不同
    // __construct($statusCode, $message = null, \Exception $previous = null, array $headers = array(), $code = 0)
}