<?php
namespace App\Domain\Entities;

use JsonSerializable;

class ItemCategoryMediumEntity implements JsonSerializable
{
    private $itemCategoryMediumCd;
    private $itemCategoryMediumName;
    private $itemCategoryLargeCd;

    public function __construct(
        $itemCategoryMediumCd,
        $itemCategoryMediumName,
        $itemCategoryLargeCd
    )
    {
        $this->itemCategoryMediumCd = $itemCategoryMediumCd;
        $this->itemCategoryMediumName = $itemCategoryMediumName;
        $this->itemCategoryLargeCd = $itemCategoryLargeCd;
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
            'itemCategoryMediumCd' => $this->itemCategoryMediumCd,
            'itemCategoryMediumName' => $this->itemCategoryMediumName,
            'itemCategoryLargeCd' => $this->itemCategoryLargeCd
        ];

        return $result;
    }
}
