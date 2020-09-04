<?php
namespace App\Domain\Entities;

class ViewAddressEntity extends BaseEntity
{
    private $addrcd;
    private $jiscode;
    private $zipcode;
    private $pref;
    private $prefName;
    private $siku;
    private $tyou;
    private $isSelect;

    public function __construct(
        $addrcd,
        $jiscode,
        $zipcode,
        $pref,
        $prefName,
        $siku,
        $tyou
    ) {
        $this->addrcd = $addrcd;
        $this->jiscode = $jiscode;
        $this->zipcode = $zipcode;
        $this->pref = $pref;
        $this->prefName = $prefName;
        $this->siku = $siku;
        $this->tyou = $tyou;
        $this->isSelect = false;
    }

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

    /**
     * JsonSerializable
     *
     * @return void
     */
    public function jsonSerialize()
    {
        $result = [
            'addrcd' => $this->addrcd,
            'jiscode' => $this->jiscode,
            'zipcode' => $this->zipcode,
            'pref' => $this->pref,
            'prefName' => $this->prefName,
            'siku' => $this->siku,
            'tyou' => $this->tyou,
            'isSelect' => $this->isSelect,
        ];

        return $result;
    }
}
