<?php
namespace App\Domain\Entities;

/**
 * メッセージ検索用Entity
 */
class MessageSearchEntity extends BaseEntity
{
    private $messageType;
    private $depoCdList;
    private $itemList;

    private $addressList;

    private $deliveryDateType;
    private $deliveryDate;
    private $deliveryDateList;
    private $deliveryDateFrom;
    private $deliveryDateTo;

    private $dayOfWeekList;
    private $publicHolidayStatusList;
    

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
