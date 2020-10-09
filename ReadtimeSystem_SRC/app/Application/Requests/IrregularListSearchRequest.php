<?php

namespace App\Application\Requests;

use App\Infrastructure\Traits\ShainOnlyRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * イレギュラー一覧　検索リクエスト
 */
class IrregularListSearchRequest extends FormRequest
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
            'searchIrregularConfig'          => 'nullable|in:1,2,3',
            'searchTitle'                    => 'nullable|max:100',
            'searchDepocd'                   => 'nullable|integer',
            'searchTransDepocd'              => 'nullable|integer',
            'searchItemCategoryLargecd'      => 'nullable|string',
            'searchItemCategoryMediumcd'     => 'nullable|string',
            'searchItemCd'                   => 'nullable|string',
            'searchOrderDate'                => 'nullable|date',
            'searchOrderPeriodStart'         => 'nullable|date',
            'searchOrderPeriodEnd'           => 'nullable|date|after:searchOrderPeriodStart',
            'searchOrderWeekList'            => 'nullable|array',
            'searchOrderHolidayList'         => 'nullable|array',
            'searchDeliveryDate'             => 'nullable|date',
            'searchDeliveryPeriodStart'      => 'nullable|date',
            'searchDeliveryPeriodEnd'        => 'nullable|date|after:searchDeliveryPeriodStart',
            'searchDeliveryWeekList'         => 'nullable|array',
            'searchDeliveryHolidayList'      => 'nullable|array',
            'searchZipcdList'                => 'nullable|array',
            'searchPrefList'                 => 'nullable|array',
            'searchSikuList'                 => 'nullable|array',
            'searchTyouList'                 => 'nullable|array',
            'searchCUseCd'                   => 'nullable|integer',
            'searchIsValid'                  => 'nullable|boolean',
            'searchDeliveryTime'             => 'nullable|integer',
            'searchIsBeforeDeadline'         => 'nullable|boolean',
            'searchIsTodayDelivery'          => 'nullable|boolean',
            'searchIsTimeSelect'             => 'nullable|boolean',
            'searchIsPrivateHome'            => 'nullable|boolean'
            
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
            'searchIrregularConfig'          => 'イレギュラー設定区分',
            'searchTitle'                    => 'タイトル',
            'searchDepocd'                   => 'デポCD',
            'searchTransDepocd'              => '振替先配送デポCD',
            'searchItemCategoryLargecd'      => '商品カテゴリ大',
            'searchItemCategoryMediumcd'     => '商品カテゴリ中',
            'searchItemCd'                   => '商品CD',
            'searchOrderDate'                => '受注日（日付）',
            'searchOrderPeriodStart'         => '受注日（期間FROM）',
            'searchOrderPeriodEnd'           => '受注日（期間TO）',
            'searchOrderWeekList'            => '受注日（曜日）',
            'searchOrderHolidayList'         => '受注日（祝日ステータス）',
            'searchDeliveryDate'             => 'お届け日（日付）',
            'searchDeliveryPeriodStart'      => 'お届け日（期間FROM）',
            'searchDeliveryPeriodEnd'        => 'お届け日（期間TO）',
            'searchDeliveryWeekList'         => 'お届け日（曜日）',
            'searchDeliveryHolidayList'      => 'お届け日（祝日ステータス）',
            'searchZipcdList'                => '郵便番号',
            'searchPrefList'                 => '都道府県CD',
            'searchSikuList'                 => '市区郡',
            'searchTyouList'                 => '町名',
            'searchCUseCd'                   => '用途',
            'searchIsValid'                  => '有効区分',
            'searchDeliveryTime'             => '配送時間',
            'searchIsBeforeDeadline'         => '前日締切不可',
            'searchIsTodayDelivery'          => '当日配送不可',
            'searchIsTimeSelect'             => '時間指定不可',
            'searchIsPrivateHome'            => '個人宅不可',

        ];
    }
}
