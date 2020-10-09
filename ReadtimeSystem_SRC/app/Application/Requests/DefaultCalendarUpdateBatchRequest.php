<?php

namespace App\Application\Requests;

use App\Infrastructure\Traits\ShainOnlyRequest;

/**
 * デフォルト設定カレンダー反映リクエスト
 */
class DefaultCalendarUpdateBatchRequest extends ApiRequest
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
            'depoCd'   => 'required|numeric',
            'startDate'   => 'required|between:8,8',
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
            'startDate'   => '適用開始日',
        ];
    }
}
