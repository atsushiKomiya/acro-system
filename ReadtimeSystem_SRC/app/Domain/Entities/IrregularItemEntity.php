<?php
namespace App\Domain\Entities;

class IrregularItemEntity extends BaseEntity
{
    private $irregularItemId;
    private $irregularId;
    private $itemCategoryLargeCd;
    private $itemCategoryMediumCd;
    private $itemCd;
    private $itemCategoryLargeName;
    private $itemCategoryMediumName;
    private $itemName;

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

}
