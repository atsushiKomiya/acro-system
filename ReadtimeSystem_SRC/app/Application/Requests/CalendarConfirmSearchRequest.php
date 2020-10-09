<?php

namespace App\Application\Requests;

use App\Infrastructure\Traits\ShainOnlyRequest;

/**
 * デポ稼働確認検索リクエスト
 */
class CalendarConfirmSearchRequest extends ApiRequest
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
            'searchPrefCd'   => 'nullable|numeric',
            'searchIsNotApproval'   => 'nullable|boolean',
            'searchIsNotConfirm'   => 'nullable|boolean',
            'searchDisplayType'   => 'required|numeric',
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
            'searchPrefCd'   => '都道府県',
            'searchIsNotApproval'   => '未承認データ',
            'searchIsNotConfirm'   => '未確認データ',
            'searchDisplayType'   => '表示タイプ',
        ];
    }
}
