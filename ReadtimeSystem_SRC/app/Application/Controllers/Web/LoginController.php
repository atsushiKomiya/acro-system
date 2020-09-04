<?php

namespace App\Application\Controllers\Web;

use App\Application\UseCases\LoginUseCase;
use App\Application\Utilities\AppUtility;
use App\Consts\AppConst;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends WebController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    // ログイン後の画面
    protected $redirectTo = '/';
    // Login ユースケース
    private $useCase;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LoginUseCase $useCase)
    {
        $this->middleware('guest')->except('logout');
        $this->useCase = $useCase;
    }

    /**
     * バリデーション変更
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'pass' => 'required|string',
            'auth_cls' => 'required',
        ]);
    }

    /**
     * 認証条件
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'pass', 'auth_cls');
    }

    /**
     * Loginエラー時
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $fromUrl = url()->previous();
        $authCls = AppUtility::getTransitionAuthCls($fromUrl);
        $url = AppUtility::getLoginErrorRedirectUrl($authCls);
        return redirect()->away($url);
    }

    /**
     * Guardの認証方法を指定
     */
    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * id名の指定
     *
     * @return string
     */
    public function username()
    {
        return 'login_cd';
    }

    /**
    * ログイン後の処理
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  mixed  $user
    * @return mixed
    */
    protected function authenticated(Request $request, $user)
    {
        // session情報取得処理
        $sessionInfo = $this->useCase->findSessionInfo($user->login_cd, $user->auth_cls);
        // ユーザ情報を格納する
        $request->session()->put(Config::get('session.user'), $sessionInfo);
    }

    /**
     * ログアウト処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        $sessionKey = Config::get('session.user');
        Auth::guard('web')->logout();
        $auth_cls = AppConst::AUTH_CLS['shain'];
        if ($request->session()->has($sessionKey)) {
            // session破棄
            $auth_cls = $request->session()->get($sessionKey)->AUTH_CLS;
            $request->session()->flush();
        }

        return $this->loggedOut($request, $auth_cls);
    }

    /**
     * ログアウトした時のリダイレクト先
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $authCls
     */
    public function loggedOut(Request $request, $authCls)
    {
        // リダイレクト先をログイン情報により変更する
        $url = AppUtility::getLoginErrorRedirectUrl($authCls);
        return redirect()->away($url);
    }
}
