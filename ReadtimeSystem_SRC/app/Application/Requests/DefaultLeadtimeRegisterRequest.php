<?php

namespace App\Application\Requests;

/**
 * デフォルト設定リードタイム情報登録リクエスト
 */
class DefaultLeadtimeRegisterRequest extends ApiRequest
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
            'leadtimeList'   => 'required|array',
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
            'leadtimeList.required'   => ':attributeに変更がありません。',
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
            'leadtimeList'   => 'リードタイム情報',
        ];
    }
}
