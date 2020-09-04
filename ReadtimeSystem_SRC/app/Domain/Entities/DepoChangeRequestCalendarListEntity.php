<?php
namespace App\Domain\Entities;

class DepoChangeRequestCalendarListEntity extends BaseEntity
{
    private $dateYm;
    private $depoCd;
    private $deliveryDate;
    private $beforeDeadlineFlg;
    private $todayDeliveryFlg;
    private $beforeDeadlineLimitTime;
    private $todayDeadlineLimitTime;
    private $dayofweek;
    private $publicHolidayStatus;
    private $annotationDepo;
    private $annotationDisp;
    private $approvalFlg;
    private $oldBeforeDeadlineFlg;
    private $oldTodayDeliveryFlg;
    private $oldBeforeDeadlineLimitTime;
    private $oldTodayDeadlineLimitTime;
    private $isChangeBefore;
    private $isChangeToday;

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
