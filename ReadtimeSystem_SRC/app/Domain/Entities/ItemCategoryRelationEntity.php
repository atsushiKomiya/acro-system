<?php
namespace App\Domain\Entities;

use JsonSerializable;

class ItemCategoryRelationEntity implements JsonSerializable
{
    private $itemCategoryRelationId;
    private $itemCategoryLargeCd;
    private $itemCategoryLargeName;
    private $itemCategoryMediumCd;
    private $itemCategoryMediumName;
    private $itemCd;
    private $itemName;

    public function __construct(
        $itemCategoryRelationId,
        $itemCategoryLargeCd,
        $itemCategoryLargeName,
        $itemCategoryMediumCd,
        $itemCategoryMediumName,
        $itemCd,
        $itemName,
        $keicho
    )
    {
        $this->itemCategoryRelationId = $itemCategoryRelationId;
        $this->itemCategoryLargeCd = $itemCategoryLargeCd;
        $this->itemCategoryLargeName = $itemCategoryLargeName;
        $this->itemCategoryMediumCd = $itemCategoryMediumCd;
        $this->itemCategoryMediumName = $itemCategoryMediumName;
        $this->itemCd = $itemCd;
        $this->itemName = $itemName;
        $this->keicho = $keicho;
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
            'itemCategoryRelationId' => $this->itemCategoryRelationId,
            'itemCategoryLargeCd' => $this->itemCategoryLargeCd,
            'itemCategoryLargeName' => $this->itemCategoryLargeName,
            'itemCategoryMediumCd' => $this->itemCategoryMediumCd,
            'itemCategoryMediumName' => $this->itemCategoryMediumName,
            'itemCd' => $this->itemCd,
            'itemName' => $this->itemName,
            'keicho' => $this->keicho
        ];

        return $result;
    }
}
