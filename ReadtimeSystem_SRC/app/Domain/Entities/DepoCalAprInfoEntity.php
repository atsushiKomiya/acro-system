<?php
namespace App\Domain\Entities;

class DepoCalAprInfoEntity extends BaseEntity
{
    // DepoCalAprInfo
    public $depoCalAprId;
    public $depoCd;
    public $dateYm;
    public $approvalDate;
    public $approvalId;
    public $confirmFlg;

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
