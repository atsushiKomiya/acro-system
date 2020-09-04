<?php

namespace App\Application\Requests;

/**
 * 住所リスト検索リクエスト
 */
class DefaultAddressSearchRequest extends ApiRequest
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
            'prefCd'   => 'required|numeric'
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
            'prefCd'   => '都道府県コード'
        ];
    }
}
