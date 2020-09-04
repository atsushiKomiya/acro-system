<?php

namespace App\Application\Requests;

/**
 * デフォルト設定カレンダー情報検索リクエスト
 */
class DefaultCalendarSearchRequest extends ApiRequest
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
