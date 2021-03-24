<?php

namespace App\Exceptions;

use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

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
        'current_password',
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
        $this->renderable(function (Throwable $e) {

            if ($e instanceof JWTException) {
                return response()->json(['Token not provided'], Response::HTTP_BAD_REQUEST);
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->json(['Model not found'], Response::HTTP_NOT_FOUND);
            }

            if ($e instanceof MethodNotAllowedHttpException || $e instanceof MethodNotAllowedException) {
                return response()->json(['Method not allowed for the specified route or route doesn\'t exist'], Response::HTTP_NOT_FOUND);
            }

        });
    }
}
