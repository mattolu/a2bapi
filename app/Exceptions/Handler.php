<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if($e instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException){
          return response()->json([
            'error'=>[
            'status'=>401,
            'message'=>'Unauthorized' ]
          ]);
        } 
        if($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException){
           return response()->json([
            'error'=>[
            'status'=>401,
            'message'=>'HTTP method not allowed' ]
          ]);
         }
         if ($e instanceof NotFoundHttpException){
            return response()->json([
                'error'=>[
                'status'=>401,
                'message'=>'Sorry, Resource not found', ]
              ]);
        }
        return parent::render($request, $e);
    }
   
}


   