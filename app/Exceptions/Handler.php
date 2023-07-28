<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });


        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                $statusCode = 400;

                if ($e instanceof HttpExceptionInterface) {
                    $statusCode = $e->getStatusCode();
                }

                return response()->json([
                    'status_code' => $statusCode,
                    'message' => $e->getMessage()
                ], $statusCode);
            }
            return parent::render($request, $e);
        });
    }
}
