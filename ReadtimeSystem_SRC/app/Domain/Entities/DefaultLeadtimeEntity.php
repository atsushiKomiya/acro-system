<?php
namespace App\Domain\Entities;

/**
 * リードタイム情報タブようのEntity
 */
class DefaultLeadtimeEntity extends BaseEntity
{
    private $depoAddressLeadtimeId;
    private $depoCd;
    private $addrcd;
    private $jiscode;
    private $zipCd;
    private $prefCd;
    private $prefName;
    private $siku;
    private $tyou;
    private $nextDayTimeType;
    private $isAreaTodayDeliveryFlg;
    private $nextDayTimeDeadline;
    private $todayTimeDeadline1;
    private $todayTimeDeadline2;

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
