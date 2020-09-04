<?php
namespace App\Domain\Entities;

class DepoChangeRequestCalendarEntity extends BaseEntity
{

    private $depoCalAprId;
    private $depoCd;
    private $dateYm;
    private $approvalDate;
    private $approvalId;
    private $confirmFlg;
    private $depoCalId;
    private $depoCalTmpId;
    private $calendarList;

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