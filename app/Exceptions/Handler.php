<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Inertia non-GET requests (DELETE, POST, PATCH) get a 302 redirect
        // which axios follows with the same method, causing "DELETE not supported
        // for route login". Return a 409 with X-Inertia-Location so Inertia
        // does a full browser GET redirect to the login page instead.
        if ($request->header('X-Inertia')) {
            return response()->json(['message' => 'Unauthenticated.'], 409, [
                'X-Inertia-Location' => route('login'),
            ]);
        }

        return parent::unauthenticated($request, $exception);
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
            if (!$request->is('api/*') && !$request->expectsJson()) {
                return Inertia::render('Error404')
                    ->toResponse($request)
                    ->setStatusCode(404);
            }
        }

        return parent::render($request, $e);
    }
}
