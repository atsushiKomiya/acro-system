<?php

namespace App\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * イレギュラー設定　削除リクエスト
 */
class IrregularDeleteRequest extends FormRequest
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
            'irregularId'   => 'required|numeric'
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
            'irregularId'   => 'イレギュラーID'
        ];
    }
}
