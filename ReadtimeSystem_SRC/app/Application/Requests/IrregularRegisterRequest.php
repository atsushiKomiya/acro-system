<?php

namespace App\Application\Requests;

/**
 * イレギュラー設定　登録リクエスト
 */
class IrregularRegisterRequest extends ApiRequest
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
            'irregular.irregularId'              => 'nullable|integer',
            'irregular.irregularType'            => 'required|integer|in:1,2,3',
            'irregular.title'                    => 'required|max:100',
            'irregular.cUse'                     => 'nullable|integer',
            'irregular.isValid'                  => 'required|boolean',
            'irregular.isBeforeDeadlineUndeliv'  => 'nullable|boolean',
            'irregular.isTodayDeadlineUndeliv'   => 'nullable|boolean',
            'irregular.isTimeSelectUndeliv'      => 'nullable|boolean',
            'irregular.timeSelect'               => 'nullable|integer',
            'irregular.isPersonalDelivery'       => 'nullable|boolean',
            'irregular.deliveryDateType'         => 'nullable|integer|in:1,2,3',
            'irregular.deliveryDate'             => 'nullable|date',
            'irregular.deliveryDateFrom'         => 'nullable|date',
            'irregular.deliveryDateTo'           => 'nullable|date|after:deliveryDateFrom',
            'irregular.orderDateType'            => 'nullable|integer|in:1,2,3',
            'irregular.orderDate'                => 'nullable|date',
            'irregular.orderDateFrom'            => 'nullable|date',
            'irregular.orderDateTo'              => 'nullable|date|after:orderDateFrom',
            'irregular.isDepo'                   => 'required|boolean',
            'irregular.isItem'                   => 'required|boolean',
            'irregular.isArea'                   => 'required|boolean',
            'irregular.annoFrom'                 => 'nullable|date',
            'irregular.annoTo'                   => 'nullable|date|after:annoFrom',
            'irregular.annoAddr'                 => 'nullable|max:255',
            'irregular.annoPeriod'               => 'nullable|max:255',
            'irregular.annoTrans'                => 'nullable|max:255',
            'irregular.errorMessage'             => 'nullable|max:255',
            'irregular.transDepoCd'              => 'nullable|integer',
            'irregular.remark'                   => 'nullable|max:255',
            'irregularDepoList'                  => 'nullable|array',
            'irregularAreaList'                  => 'nullable|array',
            'irregularItemList'                  => 'nullable|array',
            'irregularDeliveryDayofweekList'     => 'nullable|array',
            'irregularOrderDayofweekList'        => 'nullable|array',
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
            'irregular.irregularId'              => 'イレギュラーID',
            'irregular.irregularType'            => 'イレギュラー設定区分',
            'irregular.title'                    => 'タイトル',
            'irregular.cUse'                     => '用途',
            'irregular.isValid'                  => '有効フラグ',
            'irregular.isBeforeDeadlineUndeliv'  => '前日締切不可フラグ',
            'irregular.isTodayDeadlineUndeliv'   => '当日配送不可フラグ',
            'irregular.isTimeSelectUndeliv'      => '時間指定不可フラグ',
            'irregular.timeSelect'               => '時間指定',
            'irregular.isPersonalDelivery'       => '個人宅不可フラグ',
            'irregular.deliveryDateType'         => 'お届け期間・曜日区分',
            'irregular.deliveryDate'             => 'お届け日',
            'irregular.deliveryDateFrom'         => 'お届け開始日',
            'irregular.deliveryDateTo'           => 'お届け終了日',
            'irregular.orderDateType'            => '受注期間・曜日区分',
            'irregular.orderDate'                => '受注日',
            'irregular.orderDateFrom'            => '受注開始日',
            'irregular.orderDateTo'              => '受注終了日',
            'irregular.isDepo'                   => 'デポ指定フラグ',
            'irregular.isItem'                   => '商品指定フラグ',
            'irregular.isArea'                   => '地域指定フラグ',
            'irregular.annoFrom'                 => '赤字表示開始日',
            'irregular.annoTo'                   => '赤字表示終了日',
            'irregular.annoAddr'                 => '地域注釈',
            'irregular.annoPeriod'               => '期間注釈',
            'irregular.annoTrans'                => '振替注釈',
            'irregular.errorMessage'             => 'エラーメッセージ',
            'irregular.transDepoCd'              => '振替先配送デポCD',
            'irregular.remark'                   => '備考',
            'irregularDepoList'                  => 'イレギュラーデポ情報',
            'irregularAreaList'                  => 'イレギュラー地域情報',
            'irregularItemList'                  => 'イレギュラー商品情報',
            'irregularDeliveryDayofweekList'     => 'お届け日イレギュラー曜日情報',
            'irregularOrderDayofweekList'        => '受注日イレギュラー曜日情報',
        ];
    }
}
