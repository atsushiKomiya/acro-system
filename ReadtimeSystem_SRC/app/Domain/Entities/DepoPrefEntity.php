<?php
namespace App\Domain\Entities;

/**
 * デポ紐付き都道府県Entity
 */
class DepoPrefEntity extends BaseEntity
{
    private $selectPref;
    private $prefList;
    private $depoCd;

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
