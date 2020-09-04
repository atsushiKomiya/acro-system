<?php

namespace App\Application\Requests;

/**
 * デフォルト設定リードタイム情報検索リクエスト
 */
class DefaultLeadtimeSearchRequest extends ApiRequest
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
            'prefCd'   => 'numeric',
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
            'prefCd'   => '都道府県コード',
        ];
    }
}
