<?php

namespace App\Http\Middleware;

use App\Application\Responses\Api\BaseApiResponse;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class RequestResponseLog extends BaseApiResponse
{
    public $logger;

    public function __construct()
    {
        $this->logger = Log::channel('apilog')->getLogger();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->logRequest($request);

        $response = $next($request);

        $this->logResponse($response);

        return $response;
    }

    /**
     * Log request
     *
     * @param string $uniqid
     * @param \Illuminate\Http\Request $request https://laravel.com/api/5.7/Illuminate/Http/Request.html
     */
    private function logRequest($request)
    {
        $url     = $request->url();
        $header  = $request->header();
        $body    = $request->all();
        $this->logger->info("#Request", [
            "url"     => $url,
            "header"  => $header,
            "body"    => $body,
        ]);
    }

    /**
     * Log response
     * 
     * @param string $uniqid
     * @param \Illuminate\Http\Response $response https://laravel.com/api/5.7/Illuminate/Http/Response.html
     */
    private function logResponse($response)
    {
        // statusメソッド、exceptionプロパティがないレスポンスの対応
        $status = method_exists($response, 'status') ? $response->status() : '';
        $exception = property_exists($response, 'exception') ? $response->exception : '';

        $this->logger->info("#Response",
            [
                "header" => $response->headers, 
                "status" => $status, 
                "exception" => $exception,
            ]
        );
    }

}
