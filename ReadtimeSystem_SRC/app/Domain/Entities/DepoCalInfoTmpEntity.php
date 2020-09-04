<?php
namespace App\Domain\Entities;

class DepoCalInfoTmpEntity extends BaseEntity
{
    // DepoCalInfoTmp
    public $depoCalTmpId;
    public $depoCd;
    public $deliveryDate;
    public $beforeDeadlineFlg;
    public $todayDeliveryFlg;
    public $beforeDeadlineLimitTime;
    public $todayDeadlineLimitTime;
    public $dayofweek;
    public $publicHolidayStatus;
    public $annotationDepo;
    public $annotationDisp;
    public $approvalFlg;

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
