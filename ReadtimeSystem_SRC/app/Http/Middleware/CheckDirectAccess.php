<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class CheckDirectAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $domain = Config::get('app.url');
        $referrerUrl = $request->headers->get('referer');
        // 前画面が存在しない
        // 別のドメインからのアクセス
        if(!$referrerUrl || strpos($referrerUrl,$domain) === false) {
            // 直接アクセスの禁止
            $errorMsg = '直接アクセスはできません。';
            Log::error($errorMsg);
            abort(403, '直接アクセスはできません。'); 
        }
        return $next($request);
    }
}
