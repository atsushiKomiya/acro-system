<?php

namespace App\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 住所リスト検索リクエスト
 */
class MessageDuplicationSearchRequest extends FormRequest
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
            'messageType'                 => 'required|integer|in:1,2,3',
            'depoCdList'                  => 'nullable|array',
            'depoCdNameList'              => 'nullable|array',
            'itemList'                    => 'nullable|json',
            'addressList'                 => 'nullable|json',
            'deliveryDateType'            => 'nullable|integer|in:1,2,3',
            'deliveryDate'                => 'nullable|date',
            'deliveryDateFrom'            => 'nullable|date',
            'deliveryDateTo'              => 'nullable|date|after:deliveryDateFrom',
            'dayOfWeekList'               => 'nullable|array',
            'publicHolidayStatusList'     => 'nullable|array',
            'depoCalInfoList'             => 'nullable|json'
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
            'messageType'                 => 'メッセージタイプ',
            'depoCdList'                  => 'デポコード',
            'depoCdNameList'              => 'デポ名',
            'itemList'                    => '商品情報',
            'addressList'                 => '住所情報',
            'deliveryDateType'            => 'お届け期間・曜日区分',
            'deliveryDate'                => 'お届け日',
            'deliveryDateFrom'            => 'お届け開始日',
            'deliveryDateTo'              => 'お届け終了日',
            'dayOfWeekList'               => '曜日',
            'publicHolidayStatusList'     => '祝日ステータス',
            'depoCalInfoList'             => 'デポ変更申請カレンダー情報',
        ];
    }
}
