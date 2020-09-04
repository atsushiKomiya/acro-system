<?php
namespace App\Domain\Entities;

class IrregularEntity extends BaseEntity
{
    private $irregularId;
    private $irregularType;
    private $title;
    private $cUse;
    private $isValid;
    private $isBeforeDeadlineUndeliv;
    private $isTodayDeadlineUndeliv;
    private $isTimeSelectUndeliv;
    private $timeSelect;
    private $isPersonalDelivery;
    private $deliveryDateType;
    private $deliveryDate;
    private $deliveryDateFrom;
    private $deliveryDateTo;
    private $orderDateType;
    private $orderDate;
    private $orderDateFrom;
    private $orderDateTo;
    private $isDepo;
    private $isItem;
    private $isArea;
    private $annoFrom;
    private $annoTo;
    private $annoAddr;
    private $annoPeriod;
    private $annoTrans;
    private $errorMessage;
    private $transDepoCd;
    private $transDepoName;
    private $remark;
    private $name1;
    private $name2;
    
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
