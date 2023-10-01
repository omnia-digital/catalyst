<?php

namespace Modules\Livestream\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        //        \Illuminate\Auth\Access\AuthorizationException::class,
        HttpException::class,
        //        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
        \App\Exceptions\VideoProcessingNotNeededException::class,
        \App\Exceptions\TransVideoException::class,
        //        \App\Exceptions\LivestreamAccountIdNotFoundException::class
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
     * Report or log an exception.
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Exception $e
     * @return void
     *
     * @throws Exception
     */
    public function report(Throwable $e)
    {
        if (app()->bound('sentry')
            && $this->shouldReport($e)) {
            app('sentry')->captureException($e);
        }

        parent::report($e);
    }

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
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception $e
     * @return Response
     */
    public function render($request, Throwable $e)
    {
        return parent::render($request, $e);
    }
}
