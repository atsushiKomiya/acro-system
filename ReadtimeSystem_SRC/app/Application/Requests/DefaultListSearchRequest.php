<?php

namespace App\Application\Requests;

/**
 * デフォルト一覧検索APIリクエスト
 */
class DefaultListSearchRequest extends ApiRequest
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
            'prefCd'                 => 'nullable|integer',
            'depoCd'                 => 'nullable|integer',
            'itemCategoryLargecd'    => 'nullable',
            'itemCategoryMediumcd'   => 'nullable',
            'itemCd'                 => 'nullable',
            'isConfig'               => 'nullable|boolean',
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
            'prefCd'                 => '都道府県',
            'depoCd'                 => 'デポ',
            'itemCategoryLargecd'    => '商品大カテゴリ',
            'itemCategoryMediumcd'   => '商品中カテゴリ',
            'itemCd'                 => '商品',
            'isConfig'               => '未設定データフラグ',
        ];
    }
}