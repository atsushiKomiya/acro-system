<?php
namespace App\Domain\Entities;

/**
 * イレギュラー一覧画面の検索用Entity
 */
class IrregularListSearchEntity extends BaseEntity
{
    private $searchIrregularConfig;
    private $searchTitle;
    private $searchDepocd;
    private $searchDeponame;
    private $searchTransDeponame;
    private $searchTransDepocd;
    private $searchDisplayType;
    private $searchItemCategoryLargecd;
    private $searchItemCategoryLargename;
    private $searchItemCategoryMediumcd;
    private $searchItemCategoryMediumname;
    private $searchItemCd;
    private $searchItemName;
    private $searchOrderType;
    private $searchOrderDate;
    private $searchOrderPeriodStart;
    private $searchOrderPeriodEnd;
    private $searchOrderWeekList;
    private $searchOrderHolidayList;
    private $searchZipcdList;
    private $searchPrefList;
    private $searchPrefNameList;
    private $searchSikuList;
    private $searchTyouList;
    private $searchCUseCd;
    private $searchIsValid;
    private $searchDeliveryTime;
    private $searchDeliveryDateType;
    private $searchDeliveryDate;
    private $searchDeliveryPeriodStart;
    private $searchDeliveryPeriodEnd;
    private $searchDeliveryWeekList;
    private $searchDeliveryHolidayList;
    private $searchIsBeforeDeadline;
    private $searchIsTodayDelivery;
    private $searchIsTimeSelect;
    private $searchIsPrivateHome;

    /**
     * Getter.
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Setter.
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

}