<?php

namespace App\Infrastructure\Traits;

use AppConst;
use Lang;

/**
 * Request用の権限チェックTrait
 * ログインユーザーが社員、またはデポユーザーで捜査対象が自分のデポの場合のみ許可する
 */
trait ShainOrOwnDepoOnlyRequest
{
    /**
     * 操作対象のデポコードを取得する
     *
     * @return integer 操作対象のデポコード
     */
    private function getTargetDepoCd()
    {
        $targetDepoCd = $this->get('depoCd');
        return $targetDepoCd;
    }
    /**
     * ログインユーザーが社員、またはデポユーザーで操作対象が自分のデポの場合のみ許可
     *
     * @return boolean
     */
    public function authorize()
    {
        // SESSIONからユーザー情報取得
        $authInfo = $this->session()->get('auth_info');
        $targetDepoCd = $this->getTargetDepoCd();

        // 社員はOK
        if ($authInfo->AUTH_CLS == AppConst::AUTH_CLS['shain']) {
            return true;
        // デポの場合、所属するデポならOK
        } elseif ($authInfo->DEPO_CD == $targetDepoCd) {
            return true;
        }

        abort(403, Lang::get('error.AUTH.not_allowed'));
    }
}