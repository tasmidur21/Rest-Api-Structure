<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use PDOException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use TypeError;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    function render($request, Throwable $e): JsonResponse
    {
        $statusCode = ResponseCode::HTTP_INTERNAL_SERVER_ERROR;
        $message = "";
        $errors = [];
        if ($e instanceof HttpResponseException) {
            $statusCode = $e->getCode() !== 0 ? $e->getCode() : ResponseCode::HTTP_INTERNAL_SERVER_ERROR;
            $message = $e->getMessage();

        } elseif ($e instanceof ModelNotFoundException) {
            $statusCode = $e->getCode() !== 0 ? $e->getCode() : ResponseCode::HTTP_NOT_FOUND;
            $message = $statusCode === ResponseCode::HTTP_NOT_FOUND ? $e->getMessage() : $e->getMessage();

        } elseif ($e instanceof NotFoundHttpException ) {
            $statusCode = $e->getCode() !== 0 ? $e->getCode() : ResponseCode::HTTP_NOT_FOUND;
            $message = $statusCode === ResponseCode::HTTP_NOT_FOUND ? $e->getMessage() : $e->getMessage();
        }
        elseif ($e instanceof PDOException) {
            $message = 'PDO Error';

        } elseif ($e instanceof TypeError) {
            $message = 'Type Error';
            /*$message = $e->getMessage();*/

        } elseif ($e instanceof AuthenticationException) {
            $statusCode = $e->getCode() !== 0 ? $e->getCode() : ResponseCode::HTTP_INTERNAL_SERVER_ERROR;
            $message = $e->getMessage();

        } elseif ($e instanceof AuthorizationException) {
            $statusCode = $e->getCode() !== 0 ? $e->getCode() : ResponseCode::HTTP_INTERNAL_SERVER_ERROR;
            $message = $e->getMessage();

        } elseif ($e instanceof ValidationException) {
            $statusCode = ResponseCode::HTTP_UNPROCESSABLE_ENTITY;
            $message = $e->getMessage();
            $errors = $e->errors();

        } else if ($e instanceof Exception) {
            $statusCode = $e->getCode() !== 0 ? $e->getCode() : ResponseCode::HTTP_INTERNAL_SERVER_ERROR;
            $message = $e->getMessage();
        }

        return Response::json(responseBuilder($statusCode, $message, $errors), $statusCode);
    }
}
