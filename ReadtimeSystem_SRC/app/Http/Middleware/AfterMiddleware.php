<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class AfterMiddleware
{
    public function handle($request, Closure $next)
    {
        // セッションに画面IDを格納する
        $screenId = Route::currentRouteName();
        if (isset(explode('.', $screenId)[0])) {
            $screenId = explode('.', $screenId)[0];
            $this->setScreenId($request, $screenId);
        }
        
        $response = $next($request);

        return $response;
    }

    /**
     * 画面ID取得用
     */
    protected function setScreenId($request, $screenId)
    {
        // 画面ID設定
        $authInfoKey = Config::get('session.user');
        if ($request->session()->has($authInfoKey)) {
            $authInfo = $request->session()->get($authInfoKey);
            $authInfo->SCREEN_ID = $screenId;
            $request->session()->put($authInfoKey, $authInfo);
        }
    }
}
