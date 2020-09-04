<?php
namespace App\Domain\Entities;

use JsonSerializable;

class TimeSelectEntity implements JsonSerializable
{
    private $undelivType;
    private $undelivTypeName;

    public function __construct(
        $undelivType,
        $undelivTypeName
    ) {
        $this->undelivType = $undelivType;
        $this->undelivTypeName = $undelivTypeName;
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
            'undelivType' => $this->undelivType,
            'undelivTypeName' => $this->undelivTypeName
        ];

        return $result;
    }
}
