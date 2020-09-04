<?php
namespace App\Domain\Entities;

class MessageDuplicationEntity extends BaseEntity
{
    private $messageType;

    private $sort;

    private $irregularId;
    private $irregularType;
    private $annoAddr;
    private $annoPeriod;
    private $annoTrans;
    private $errorMessage;

    private $depoCalId;
    private $depoCd;
    private $dateYm;
    private $deliveryDate;
    private $annotationDisp;
    private $dayofweek;
    private $publicHolidayStatus;

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
