<?php

namespace App\Http\Middleware;

use Closure;
use App\Consts\AppConst;

class CheckAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        // SESSIONからユーザー情報取得
        $authInfo = $request->session()->get('auth_info');

        // 検索対象のデポコードを判定
        if ($authInfo->AUTH_CLS != AppConst::AUTH_CLS['shain']) {
            // Error画面へリダイレクト
            abort(403, '直接アクセスはできません。'); 
        }
        
        $response = $next($request);

        return $response;
    }
}
