<?php
namespace App\Domain\Factories;

use App\Domain\Entities\ItemCategoryMediumEntity;
use App\Domain\Entities\ItemCategoryRelationEntity;
use App\Domain\Models\ItemCategoryMedium;

class ItemCategoryMediumFactory
{

    /**
     * ItemCategoryMediumEntity作成
     *
     * @param ItemCategoryMedium $itemCategoryMedium
     * @return ItemCategoryMediumEntity
     */
    public function makeItemCategoryMedium(ItemCategoryRelationEntity $itemCategoryRelationEntity): ItemCategoryMediumEntity
    {
        return new ItemCategoryMediumEntity(
            $itemCategoryRelationEntity->itemCategoryMediumCd,
            $itemCategoryRelationEntity->itemCategoryMediumName,
            $itemCategoryRelationEntity->itemCategoryLargeCd
        );
    }

    /**
     * ItemCategoryMediumEntity作成
     *
     * @param ItemCategoryMedium $itemCategoryMedium
     * @return ItemCategoryMediumEntity
     */
    public function make(ItemCategoryMedium $itemCategoryMedium): ItemCategoryMediumEntity
    {
        return new ItemCategoryMediumEntity(
            $itemCategoryMedium->category_medium_cd,
            $itemCategoryMedium->category_medium_name,
            null
        );
    }
}
