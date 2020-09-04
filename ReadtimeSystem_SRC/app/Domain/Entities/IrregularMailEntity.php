<?php
namespace App\Domain\Entities;

/**
 * イレギュラー設定画面のメール用Entity
 */
class IrregularMailEntity extends BaseEntity
{
    private $irregularId;
    private $title;
    private $irregularType;
    private $cUse;
    private $isValid;
    private $isBeforeDeadlineUndeliv;
    private $isTodayDeadlineUndeliv;
    private $isTimeSelectUndeliv;
    private $timeSelect;
    private $isPersonalDelivery;
    private $orderDateType;
    private $orderDate;
    private $orderDateFrom;
    private $orderDateTo;
    // イレギュラー曜日情報テーブルのリスト - 日付区分 1:お届け日の曜日、祝日ステータスを持つ
    private $irregularOrderDayofweekList;
    private $deliveryDateType;
    private $deliveryDate;
    private $deliveryDateFrom;
    private $deliveryDateTo;
    // イレギュラー曜日情報テーブルのリスト - 日付区分 2:受注日の曜日、祝日ステータスを持つ
    private $irregularDeliveryDayofweekList;
    // イレギュラーデポ情報テーブルのリスト - デポCD、デポ名を持つ
    private $irregularDepoList;
    // イレギュラー商品情報テーブルのリスト - 商品CD、商品名を持つ
    private $irregularItemList;
    // イレギュラー地域情報テーブルのリスト - 都道府県CD、市区郡、町村を持つ
    private $irregularAreaList;
    private $transDepoCd;
    private $transDepoName;
    private $annoAddr;
    private $annoPeriod;
    private $annoTrans;
    private $errorMessage;
    private $name1;
    private $name2;

    public function __construct(
        $irregularId,
        $title,
        $irregularType,
        $cUse,
        $isValid,
        $isBeforeDeadlineUndeliv,
        $isTodayDeadlineUndeliv,
        $isTimeSelectUndeliv,
        $timeSelect,
        $isPersonalDelivery,
        $orderDateType,
        $orderDate,
        $orderDateFrom,
        $orderDateTo,
        $irregularOrderDayofweekList,
        $deliveryDateType,
        $deliveryDate,
        $deliveryDateFrom,
        $deliveryDateTo,
        $irregularDeliveryDayofweekList,
        $irregularDepoList,
        $irregularItemList,
        $irregularAreaList,
        $transDepoCd,
        $transDepoName,
        $annoAddr,
        $annoPeriod,
        $annoTrans,
        $errorMessage,
        $createdAt,
        $createdId,
        $name1,
        $name2
    ) {
        $this->irregularId = $irregularId;
        $this->title = $title;
        $this->irregularType = $irregularType;
        $this->cUse = $cUse;
        $this->isValid = $isValid;
        $this->isBeforeDeadlineUndeliv = $isBeforeDeadlineUndeliv;
        $this->isTodayDeadlineUndeliv = $isTodayDeadlineUndeliv;
        $this->isTimeSelectUndeliv = $isTimeSelectUndeliv;
        $this->timeSelect = $timeSelect;
        $this->isPersonalDelivery = $isPersonalDelivery;
        $this->orderDateType = $orderDateType;
        $this->orderDate = $orderDate;
        $this->orderDateFrom = $orderDateFrom;
        $this->orderDateTo = $orderDateTo;
        $this->irregularOrderDayofweekList = $irregularOrderDayofweekList;
        $this->deliveryDateType = $deliveryDateType;
        $this->deliveryDate = $deliveryDate;
        $this->deliveryDateFrom = $deliveryDateFrom;
        $this->deliveryDateTo = $deliveryDateTo;
        $this->irregularDeliveryDayofweekList = $irregularDeliveryDayofweekList;
        $this->irregularDepoList = $irregularDepoList;
        $this->irregularItemList = $irregularItemList;
        $this->irregularAreaList = $irregularAreaList;
        $this->transDepoCd = $transDepoCd;
        $this->transDepoName = $transDepoName;
        $this->annoAddr = $annoAddr;
        $this->annoPeriod = $annoPeriod;
        $this->annoTrans = $annoTrans;
        $this->errorMessage = $errorMessage;
        $this->createdAt = $createdAt;
        $this->createdId = $createdId;
        $this->name1 = $name1;
        $this->name2 = $name2;
    }

    /**
     * Getter.
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }
}
