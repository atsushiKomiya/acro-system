<?php

namespace App\Application\Requests;

use App\Infrastructure\Traits\ShainOnlyRequest;

/**
 * デポ稼働確認　承認リクエスト
 */
class DepoApprovalRequest extends ApiRequest
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
            'depoCd'                             => 'required|numeric',
            'dateYm'                             => 'required|min:6|max:6',
            'calendarList.*.deliveryDate'        => 'required|min:8|max:8',
            'calendarList.*.annotationDepo'      => 'max:1000',
            'calendarList.*.annotationDisp'      => 'max:1000',
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
            'calendarList.*.deliveryDate'     => '届日',
            'calendarList.*.annotationDepo'   => '変更理由',
            'calendarList.*.annotationDisp'   => '変更理由（表示）',
        ];
    }
}
