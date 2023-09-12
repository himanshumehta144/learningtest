<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Response;
use App\Services\ApiResponse\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponse;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }



    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? $this->sendResponse([], $exception->getMessage(), Response::HTTP_UNAUTHORIZED)
            : redirect()->guest($exception->redirectTo() ?? route('login'));
    }


    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return $this->sendResponse([], $exception->validator->errors(), $exception->status);
    }


    /**
     * Convert the given exception to an array.
     *
     * @param  \Throwable  $e
     * @return array
     */
    protected function convertExceptionToArray(Throwable $e)
    {
        $status = $this->isHttpException($e) ? $e->getStatusCode() :  Response::HTTP_INTERNAL_SERVER_ERROR;
        if($e instanceof NotFoundHttpException){
            $message = empty($e->getMessage()) ? 'Route not found' : $e->getMessage();
            return $this->sendArrayResponse([], $message, $status);
        }
        if (config('app.debug')) {
            $error = collect($this->sendArrayResponse([], $e->getMessage(), $status) );
            $error = $error->merge([
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                // 'trace' => collect($e->getTrace())->map(function ($trace) {
                //     return Arr::except($trace, ['args']);
                // })->all(),
            ]);
            return $error->toArray();
        } else {
            return $this->sendArrayResponse([], $e->getMessage(), $status);
        }
    }
}
