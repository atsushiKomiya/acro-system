<?php
namespace App\Domain\Entities;

class IrregularDayofweekEntity extends BaseEntity
{
    private $irregularDayofweekId;
    private $irregularId;
    private $dateType;
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
