<?php

namespace warehouse\Exceptions;

// use Exception;
// use Illuminate\Auth\AuthenticationException;
// use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Exception;
use Request;
use Illuminate\Auth\AuthenticationException;
use Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    // public function report(Exception $exception)
    // {
    //     parent::report($exception);
    // }

    public function report(Exception $exception)
{
    if (app()->bound('sentry') && $this->shouldReport($exception)) {
        app('sentry')->captureException($exception);
    }

    parent::report($exception);
}

    // /**
    //  * Render an exception into an HTTP response.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \Exception  $exception
    //  * @return \Illuminate\Http\Response
    //  */
    //  public function render($request, Exception $e)
    //   {
    //       if ($this->isHttpException($e))
    //       {
    //           return $this->renderHttpException($e);
    //       }
    //
    //       if (config('app.debug'))
    //       {
    //           return $this->renderExceptionWithWhoops($e);
    //       }
    //
    //       return parent::render($request, $e);
    //   }
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Yajra\DataTables\Exception) {
            return response([
                'draw'            => 0,
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
                'error'           => 'Laravel Error Handler',
            ]);
        }

        return parent::render($request, $exception);
    }

          /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function renders($request, Exception $exception)
    {
        if ($exception instanceof CustomException) {
            return response()->view('errors.custom', [], 500);
        }

        return parent::renders($request, $exception);
    }

      /**
     * Render an exception using Whoops.
     *
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    protected function renderExceptionWithWhoops(Exception $e)
    {
        // PrettyPageHandler - Shows a pretty error page when something goes pants-up
        // PlainTextHandler - Outputs plain text message for use in CLI applications
        // CallbackHandler - Wraps a closure or other callable as a handler. You do not need to use this handler explicitly, whoops will automatically wrap any closure or callable you pass to Whoops\Run::pushHandler
        // JsonResponseHandler - Captures exceptions and returns information on them as a JSON string. Can be used to, for example, play nice with AJAX requests.
        // XmlResponseHandler - Captures exceptions and returns information on them as a XML string. Can be used to, for example, play nice with AJAX requests.
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
        $whoops->register();

        return new \Illuminate\Http\Response(
            $whoops->handleException($e),
            $e->getStatusCode(),
            $e->getHeaders()
        );
    }
    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            response()->json(['message' => 'Unauthenticated.'], 401);

        }
        return redirect()->guest(route('login'));
        //   /** return response()->json(['error' => 'Unauthenticated.'], 401); */

        //   $response = ['status' => 'error','message' => 'You pass invalid token '];

        //   return response()->json($response);
        // return $request->expectsJson()
        //             ? response()->json(['message' => 'Unauthenticated.'], 401)
        //             : false;
                    // : redirect()->guest(route('login'));
                    // dd($request->expectsJson());
                //    return response()->json(['message' => 'Unauthenticated.'], 401);
        // return redirect()->guest(route('dashboard'));
    }
}
