<?php

namespace App\Exceptions;

use App\Http\Controllers\ResponseTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if (!empty($e)) {
            if (!env('APP_DEBUG')) {
                $this->setErrorMessage('Sorry, but something went wrong...', 500);
                return $this->getResponse();
            } else {
                $this->setErrorMessage($e->getMessage());
                $this->setResponseData([
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTrace()
                ], 500, false);
                return $this->getResponse();
            }
        }

        return parent::render($request, $e);
    }
}
