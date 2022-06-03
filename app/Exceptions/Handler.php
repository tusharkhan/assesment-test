<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    public function render($request, Throwable $e)
    {
        if ($e instanceof NotFoundHttpException) {
            return sendError(
                'Not Found',
                ['error' => ['The requested URL was not found on this server.']],
                Response::HTTP_NOT_FOUND);
        } else if( $e instanceof MethodNotAllowedHttpException ){
            return sendError(
                'Bad Method',
                ['error' => ['The requested URL was not found on this server.']],
                Response::HTTP_NOT_FOUND);
        }

        return parent::render($request, $e);
    }
}
