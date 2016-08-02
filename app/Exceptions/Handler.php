<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Dingo\Api\Exception\ResourceException;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Exceptions\NotFoundException;
use App\Exceptions\AuthorizationException;
use App\Exceptions\ValidationException;
    
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof AuthorizationException) {
            $message  = $e->getMessage() ?: '您没有权限操作';
            $code     = $e->getCode() ?: 401;
            
            return \Response::make(array(
               'meta' => array(
                   'message' => $message,
                   'status_code' => $code
               ) 
            ), 200);
        }
        
        if ($e instanceof NotFoundException) {
            $message  = $e->getMessage() ?: '访问记录不存在或被删除';
            $code     = $e->getCode() ?: 404;
            
            return \Response::make(array(
               'meta' => array(
                   'message' => $message,
                   'status_code' => $code
               ) 
            ), 200);
        }
        
        if ($e instanceof ValidationException) {
            $message  = $e->getMessage() ?: '访问记录不存在或被删除';
            $code     = $e->getCode() ?: 422;
            $errors   = $e->getErrors();
            
            return \Response::make(array(
               'meta' => array(
                   'message' => $message,
                   'status_code' => $code,
                   'errors' => $errors
               ) 
            ), 200);
        }
        
        if ($e instanceof JWTException) {
            $message  = $e->getMessage() ?: 'token_invalid';
            $code     = $e->getCode() ?: 500;
            return \Response::make(array(
               'meta' => array(
                   'message' => $message,
                   'status_code' => $code
               ) 
            ), 200);
        }
        
        // if($e instanceof \Symfony\Component\Debug\Exception\FatalErrorException
        //         && !config('app.debug')) {
        //     return response()->view('errors.default', [], 500);
        // }
        
        return parent::render($request, $e);
    }
}
