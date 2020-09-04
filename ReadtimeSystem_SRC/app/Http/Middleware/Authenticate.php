<?php

namespace App\Http\Middleware;

use App\Application\Utilities\AppUtility;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $fromUrl = url()->previous();
            $authCls = AppUtility::getTransitionAuthCls($fromUrl);
            $url = AppUtility::getLoginErrorRedirectUrl($authCls);
            return $url;
        }
    }
}
