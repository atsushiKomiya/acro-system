<?php

namespace App\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * デポ休業等申請　検索リクエスト
 */
class DepoRequestRequest extends FormRequest
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
            'searchYm'   => 'required|min:6|max:6',
            'searchDepocd'   => 'required|numeric'
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
            'searchYm'   => '年月',
            'searchDepocd'   => '配送デポ',
        ];
    }
}
