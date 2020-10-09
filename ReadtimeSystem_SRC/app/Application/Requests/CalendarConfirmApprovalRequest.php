<?php

namespace App\Application\Requests;

use App\Infrastructure\Traits\ShainOnlyRequest;

/**
 * デポ稼働確認承認リクエスト
 */
class CalendarConfirmApprovalRequest extends ApiRequest
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
            'searchYm'   => 'required|between:6,6',
            'depoCd'   => 'required|numeric'
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
            'searchYm'   => '対象年月',
            'depoCd'   => 'デポコード',
        ];
    }
}
