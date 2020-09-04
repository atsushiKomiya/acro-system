<?php
namespace App\Domain\Entities;

class IrregularAreaEntity extends BaseEntity
{
    private $irregularAreaId;
    private $irregularId;
    private $addrCd;
    private $zipcode;
    private $prefCd;
    private $prefName;
    private $siku;
    private $tyou;

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
            'irregularAreaId' => $this->irregularAreaId,
            'irregularId' => $this->irregularId,
            // ※重要　ViewAddressに合わせているため、Cd小文字
            'addrcd' => $this->addrCd,
            'zipcode' => $this->zipcode,
            // ※重要　ViewAddressに合わせているため、Cd抜き
            'pref' => $this->prefCd,
            'prefName' => $this->prefName,
            'siku' => $this->siku,
            'tyou' => $this->tyou,
        ];

        return $result;
    }
}
