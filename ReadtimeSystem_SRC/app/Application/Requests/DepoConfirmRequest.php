<?php

namespace App\Application\Requests;

/**
 * デポ稼働確認　検索リクエスト
 */
class DepoConfirmRequest extends ApiRequest
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
