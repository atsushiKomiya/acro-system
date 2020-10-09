<?php

namespace App\Application\Requests;

use App\Infrastructure\Traits\ShainOrOwnDepoOnlyRequest;

/**
 * デポ稼働確認　検索リクエスト
 */
class DepoConfirmRequest extends ApiRequest
{
    /** 社員、またはデポユーザーで自分のデポ対象のみ実行可能 */
    use ShainOrOwnDepoOnlyRequest;

    /**
     * バリデーション
     *
     * @return array
     */
    public function rules()
    {
        return [
            'depoCd'   => 'required|numeric',
            'dateYm'   => 'required|min:6|max:6',
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
            'depoCd'   => 'デポコード',
            'dateYm'   => '対象年月',
        ];
    }
}
