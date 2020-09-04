<?php

namespace App\Exceptions;

use App\Application\Responses\Api\BaseApiResponse;
use Illuminate\Auth\AuthenticationException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {

            $erros = $exception->getMessage();
            $res = new BaseApiResponse();
            $httpCode = 500;
            if($exception instanceof HttpException) {
                $httpCode = $exception->getStatusCode();
            }
            $res->apiFailed($httpCode, $erros);
            return $res;
        } else {
            if ($this->isHttpException($exception)) {
                // renderHttpExceptionへ渡す。
                return $this->renderHttpException($exception);
            } elseif ($exception instanceof AuthenticationException) {
                return parent::render($request, $exception);
            } else {
                // その他のシステムエラーはerrors/500を表示する。
                return response()->view("errors.500");
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpExceptionInterface $exception)
    {
        $message = '';
        switch ($exception->getStatusCode()) {
            case 403:
                $message = "許可されていません。アクセスが拒否されました。";
                break;
            case 404:
                $message = "お探しのページが見つかりませんでした。";
                break;
            default:
                $message = "お探しの方法ではアクセスできません。";
                break;
        }

        return response()->view('errors.error', ['message' => $message]); //ビューを返せる
    }
}
