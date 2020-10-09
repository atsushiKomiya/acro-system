<?php

namespace App\Application\Requests;

use App\Infrastructure\Traits\ShainOnlyRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * イレギュラー設定　削除リクエスト
 */
class IrregularDeleteRequest extends FormRequest
{
    /** 社員のみ実行可能 */
    use ShainOnlyRequest;

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
