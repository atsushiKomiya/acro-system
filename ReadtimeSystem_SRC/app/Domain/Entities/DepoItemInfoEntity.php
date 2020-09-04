<?php
namespace App\Domain\Entities;

/**
 * デポ取扱商品のEntity
 */
class DepoItemInfoEntity extends BaseEntity
{
    private $depoItemInfoId;
    private $depoCd;
    private $itemCategoryLargeCd;
    private $itemCategoryLargeName;
    private $itemCategoryMediumCd;
    private $itemCategoryMediumName;
    private $itemCd;
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
