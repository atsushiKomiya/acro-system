<?php

namespace App\Application\Requests;

use App\Infrastructure\Traits\ShainOrOwnDepoOnlyRequest;
use AppConst;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * デポ休業等申請　検索リクエスト
 */
class DepoRequestRequest extends FormRequest
{
    /** 社員、またはデポユーザーで自分のデポ対象のみ実行可能 */
    use ShainOrOwnDepoOnlyRequest;

    /**
     * 操作対象のデポコードを取得する(権限チェック用)
     *
     * @return integer 操作対象のデポコード
     */
    private function getTargetDepoCd()
    {
        $targetDepoCd = $this->get('searchDepocd');

        // 検索対象のデポコードが指定されていない場合で、ログインユーザーがデポユーザーの場合は
        // 検索対象を所属デポとして判定する
        if(!$targetDepoCd){
            $authInfo = $this->session()->get('auth_info');
            if ($authInfo->AUTH_CLS == AppConst::AUTH_CLS['depo']) {
                $targetDepoCd = $authInfo->DEPO_CD;
            }
        }

        return $targetDepoCd;
    }

    /**
     * バリデーション
     *
     * @return array
     */
    public function rules()
    {
        return [
            'searchYm'   => 'nullable|min:6|max:6',
            'searchDepocd'   => 'nullable|numeric'
        ];
    }

    /**
     * 項目名
     *
     * @return void
     */
    public function attributes()
    {
        return [
            'searchYm'   => '年月',
            'searchDepocd'   => '配送デポ',
        ];
    }
}
