<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        \Illuminate\Validation\ValidationException::class,
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
     * Report or log an exception.
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
    public function render($request, Exception $exception)
    {
    	if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
	        return redirect('/')->withErrors(['token_error' => 'Sorry, your session seems to have expired. Please try again.']);
	    }

        return parent::render($request, $exception);
    }

     /** Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception) {
        /*if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }*/

        // echo "<pre>";
        // print_r(get_class_methods($exception));
        // print_r($exception->getMessage());
        // print_r($exception->getCode());
        // echo "</pre>";
        // die;

        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
	        return redirect('/')->withErrors(['token_error' => 'Sorry, your session seems to have expired. Please try again.']);
	    }

        if ($request->expectsJson()) {
            return response()->json(['code' => 400, 'message' => 'Sorry, your session seems to have expired. Please try again..', 'data' => new \stdClass()],401);
        }

        if ($request->expectsJson()) {
            /** return response()->json(['error' => 'Unauthenticated.'], 401); */
            $response = ['code' => 400, 'message' => 'You pass invalid token','data' => new \stdClass() ];
            return response()->json($response);
        }

        $guard = array_get($exception->guards(), 0);
        switch ($guard) {
          case 'admin':
            $login = 'admin.auth.login';
            break;
          default:
            $login = 'login';
            break;
        }
        return redirect()->guest(route($login));
        //return redirect()->guest(route('login'));
    }
}
