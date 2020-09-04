<?php

namespace App\Application\Requests;

/**
 * デフォルト設定カレンダー反映リクエスト
 */
class DefaultCalendarUpdateBatchRequest extends ApiRequest
{
    /**
     * 認証有無
     *
     * @return boolean
     */
    public function authorize()
    {
        return true;
    }

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
