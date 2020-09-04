<?php

namespace App\Application\Requests;

/**
 * デフォルト設定デポ住所コード紐付情報登録リクエスト
 */
class DefaultDepoAddressRegisterRequest extends ApiRequest
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
            'depoAddressList'   => 'required|array',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'depoAddressList.required'   => ':attributeに変更がありません。',
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
            'depoAddressList'   => 'デポ取扱住所リスト',
        ];
    }
}
