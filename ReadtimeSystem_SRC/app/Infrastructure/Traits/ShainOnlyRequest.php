<?php

namespace App\Infrastructure\Traits;

use AppConst;
use Lang;

/**
 * Request用の権限チェックTrait
 * ログインユーザーが社員の場合のみ許可する
 */
trait ShainOnlyRequest
{
    /**
     * ログインユーザーが社員の場合のみ許可
     *
     * @return boolean
     */
    public function authorize()
    {
        // SESSIONからユーザー情報取得
        $authInfo = $this->session()->get('auth_info');

        // 社員はOK
        if ($authInfo->AUTH_CLS == AppConst::AUTH_CLS['shain']) {
            return true;
        }

        abort(403, Lang::get('error.AUTH.not_allowed'));
    }
}