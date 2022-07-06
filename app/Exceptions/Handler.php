<?php

namespace App\Exceptions;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class
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


//    public function register()
//    {

//        $this->reportable(function (Throwable $e) {
//            //
//        });

//        $this->renderable(function (\Exception $exception, $request) {
//            $apiResponseObject = new Controller();
//            if ($request->is('api/*')) {
//                if ($exception instanceof MethodNotAllowedHttpException) {
//                    return $apiResponseObject->respond([],[],$exception->getCode(),$exception->getMessage());
//                }
//
//                if ($exception instanceof ModelNotFoundException) {
//                    return $apiResponseObject->respond([],[$exception->getMessage()],$exception->getCode(),'Not Found!');
//                }
//
//                if ($exception instanceof NotFoundHttpException) {
//                    return $apiResponseObject->respond([],[$exception->getMessage()],$exception->getCode(),'Not Found!');
//                }
//
//                if ($exception instanceof AuthenticationException) {
//                    return $apiResponseObject->respond([],[$exception->getMessage()],401,$exception->getMessage());
//                }
//            }
//        });
//    }


    /**
     * Report or log an exception.
     *
     * @param Exception $exception
     * @return void
     *
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Exception $exception
     * @return Response
     *
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {
        $apiResponseObject = new Controller();
        if ($request->is('api/*')) {
            if ($exception instanceof MethodNotAllowedHttpException) {
                return $apiResponseObject->respond([],[],$exception->getCode(),$exception->getMessage());
            }

            if ($exception instanceof ModelNotFoundException) {
                return $apiResponseObject->respond([],[$exception->getMessage()],$exception->getCode(),'Not Found!');
            }

            if ($exception instanceof NotFoundHttpException) {
                return $apiResponseObject->respond([],[$exception->getMessage()],$exception->getCode(),'Not Found!');
            }

            if ($exception instanceof AuthenticationException) {
                return $apiResponseObject->respond([],[$exception->getMessage()],401,$exception->getMessage());
            }
        }
        return parent::render($request, $exception);
    }
}
