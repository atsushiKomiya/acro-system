<?php

namespace App\Application\Requests;

/**
 * デフォルト設定デポ商品コード紐付情報登録リクエスト
 */
class DefaultDepoItemRegisterRequest extends ApiRequest
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
            'depoItemList'   => 'required|array',
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
            'depoItemList.required'   => ':attributeに変更がありません。',
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
            'depoItemList'   => 'デポ取扱商品リスト',
        ];
    }
}
