<?php
namespace App\Domain\Entities;

use JsonSerializable;

class DisplayGroupEntity implements JsonSerializable
{
    private $displayGroupType;
    private $displayGroupName;

    public function __construct(
        $displayGroupType,
        $displayGroupName
    )
    {
        $this->displayGroupType = $displayGroupType;
        $this->displayGroupName = $displayGroupName;
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
            'displayGroupType' => $this->displayGroupType,
            'displayGroupName' => $this->displayGroupName,
        ];

        return $result;
    }
}
