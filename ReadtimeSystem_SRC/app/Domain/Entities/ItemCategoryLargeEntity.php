<?php
namespace App\Domain\Entities;

use JsonSerializable;

class ItemCategoryLargeEntity implements JsonSerializable
{
    private $itemCategoryLargeCd;
    private $itemCategoryLargeName;

    public function __construct(
        $itemCategoryLargeCd,
        $itemCategoryLargeName
    )
    {
        $this->itemCategoryLargeCd = $itemCategoryLargeCd;
        $this->itemCategoryLargeName = $itemCategoryLargeName;
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
            'itemCategoryLargeCd' => $this->itemCategoryLargeCd,
            'itemCategoryLargeName' => $this->itemCategoryLargeName,
        ];

        return $result;
    }
}
