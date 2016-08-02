<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class StoreFailedException extends HttpException
{
    // 参数顺序与Exception不同
}