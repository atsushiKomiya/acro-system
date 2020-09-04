<?php
namespace App\Auth;

use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class HyumonySessionGuard extends SessionGuard
{
    protected function cycleRememberToken(AuthenticatableContract $user)
    {
//        $user->setRememberToken($token = Str::random(60));
//        $this->provider->updateRememberToken($user, $token);
    }
}
