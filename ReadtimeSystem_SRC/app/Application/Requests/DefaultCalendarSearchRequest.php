<?php

namespace App\Application\Requests;

use App\Infrastructure\Traits\ShainOnlyRequest;

/**
 * デフォルト設定カレンダー情報検索リクエスト
 */
class DefaultCalendarSearchRequest extends ApiRequest
{
    /** 社員のみ実行可能 */
    use ShainOnlyRequest;

    /**
     * バリデーション
     *
     * @return array
     */
    public function rules()
    {
        return [
            'depoCd'   => 'required|numeric'
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
        ];
    }
}
