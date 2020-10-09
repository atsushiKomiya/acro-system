<?php

namespace App\Application\Requests;

use App\Infrastructure\Traits\ShainOnlyRequest;

class DefaultCalendarRegisterRequest extends ApiRequest
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
            'depoCd'   => 'required|numeric',
            'monBeforeDeadlineFlg'   => 'required|boolean',
            'monTodayDeliveryFlg'   => 'required|boolean',
            'tueBeforeDeadlineFlg'   => 'required|boolean',
            'tueTodayDeliveryFlg'   => 'required|boolean',
            'wedBeforeDeadlineFlg'   => 'required|boolean',
            'wedTodayDeliveryFlg'   => 'required|boolean',
            'thuBeforeDeadlineFlg'   => 'required|boolean',
            'thuTodayDeliveryFlg'   => 'required|boolean',
            'friBeforeDeadlineFlg'   => 'required|boolean',
            'friTodayDeliveryFlg'   => 'required|boolean',
            'satBeforeDeadlineFlg'   => 'required|boolean',
            'satTodayDeliveryFlg'   => 'required|boolean',
            'sunBeforeDeadlineFlg'   => 'required|boolean',
            'sunTodayDeliveryFlg'   => 'required|boolean',
            'holiBeforeDeadlineFlg'   => 'required|boolean',
            'holiBeforeTodayDeliveryFlg'   => 'required|boolean',
            'holiDeadlineFlg'   => 'required|boolean',
            'holiTodayDeliveryFlg'   => 'required|boolean',
            'holiAfterDeadlineFlg'   => 'required|boolean',
            'holiAfterTodayDeliveryFlg'   => 'required|boolean',
            'privateHomeFlg'   => 'required|boolean',
            'handingFlg'   => 'required|boolean',
            'congratulationKbnFlg'   => 'required|between:1,4|numeric',
            'transferPostDepoCd'   => 'nullable|numeric',
            'depoLeadTime'   => 'required|between:0,99|integer',
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
            'monBeforeDeadlineFlg'   => '前日締切（月）',
            'monTodayDeliveryFlg'   => '当日配送（月）',
            'tueBeforeDeadlineFlg'   => '前日締切（火）',
            'tueTodayDeliveryFlg'   => '当日配送（火）',
            'wedBeforeDeadlineFlg'   => '前日締切（水）',
            'wedTodayDeliveryFlg'   => '当日配送（水）',
            'thuBeforeDeadlineFlg'   => '前日締切（木）',
            'thuTodayDeliveryFlg'   => '当日配送（木）',
            'friBeforeDeadlineFlg'   => '前日締切（金）',
            'friTodayDeliveryFlg'   => '当日配送（金）',
            'satBeforeDeadlineFlg'   => '前日締切（土）',
            'satTodayDeliveryFlg'   => '当日配送（土）',
            'sunBeforeDeadlineFlg'   => '前日締切（日）',
            'sunTodayDeliveryFlg'   => '当日配送（日）',
            'holiBeforeDeadlineFlg'   => '前日締切（祝前）',
            'holiBeforeTodayDeliveryFlg'   => '当日配送（祝前）',
            'holiDeadlineFlg'   => '前日締切（祝日）',
            'holiTodayDeliveryFlg'   => '当日配送（祝日）',
            'holiAfterDeadlineFlg'   => '前日締切（祝後）',
            'holiAfterTodayDeliveryFlg'   => '当日配送（祝後）',
            'privateHomeFlg'   => '個人宅可否',
            'handingFlg'   => '手持ちお届け可否',
            'congratulationKbnFlg'   => '慶弔区分可否',
            'transferPostDepoCd'   => '振替先配送デポコード',
            'depoLeadTime'   => 'デポリードタイム',
        ];
    }
}
