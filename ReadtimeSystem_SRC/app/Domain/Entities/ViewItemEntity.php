<?php
namespace App\Domain\Entities;

use JsonSerializable;

class ViewItemEntity implements JsonSerializable
{
    private $itemCd;
    private $itemName;
    private $itemCategoryLargeCd;
    private $itemCategoryMediumCd;
    private $isSelect;

    public function __construct(
        $itemCd,
        $itemName,
        $itemCategoryLargeCd = null,
        $itemCategoryLargeName = null,
        $itemCategoryMediumCd = null,
        $itemCategoryMediumName = null,
        $keicho = null
    )
    {
        $this->itemCd = $itemCd;
        $this->itemName = $itemName;
        $this->itemCategoryLargeCd = $itemCategoryLargeCd;
        $this->itemCategoryLargeName = $itemCategoryLargeName;
        $this->itemCategoryMediumCd = $itemCategoryMediumCd;
        $this->itemCategoryMediumName = $itemCategoryMediumName;
        $this->keicho = $keicho;
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
            'itemCd' => $this->itemCd,
            'itemName' => $this->itemName,
            'itemCategoryLargeCd' => $this->itemCategoryLargeCd,
            'itemCategoryLargeName' => $this->itemCategoryLargeName,
            'itemCategoryMediumCd' => $this->itemCategoryMediumCd,
            'itemCategoryMediumName' => $this->itemCategoryMediumName,
            'keicho' => $this->keicho,
            'isSelect' => $this->isSelect
        ];

        return $result;
    }
}
