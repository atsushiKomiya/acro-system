<?php
namespace App\Domain\Entities;

use JsonSerializable;

class PrefEntity implements JsonSerializable
{
    private $pref;
    private $prefName;
    private $isSelect;

    public function __construct(
        $pref,
        $prefName
    )
    {
        $this->pref = $pref;
        $this->prefName = $prefName;
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
     * JsonSerializable
     *
     * @return void
     */
    public function jsonSerialize()
    {
        $result = [
            'pref' => $this->pref,
            'prefName' => $this->prefName,
            'isSelect' => $this->isSelect
        ];

        return $result;
    }
}
