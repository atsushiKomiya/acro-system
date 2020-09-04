<?php
namespace App\Domain\Entities;

use JsonSerializable;

class CUseEntity implements JsonSerializable
{
    private $cUse;
    private $keichoType;
    private $cUseName;

    public function __construct(
        $cUse,
        $keichoType,
        $cUseName
    )
    {
        $this->cUse = $cUse;
        $this->keichoType = $keichoType;
        $this->cUseName = $cUseName;
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
            'cUse' => $this->cUse,
            'keichoType' => $this->keichoType,
            'cUseName' => $this->cUseName
        ];

        return $result;
    }
}
