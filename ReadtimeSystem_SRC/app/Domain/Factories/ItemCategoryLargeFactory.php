<?php
namespace App\Domain\Factories;

use App\Domain\Entities\ItemCategoryLargeEntity;
use App\Domain\Entities\ItemCategoryRelationEntity;
use App\Domain\Models\ItemCategoryLarge;

class ItemCategoryLargeFactory
{

    /**
     * ItemCategoryLargeEntity作成
     *
     * @param ItemCategoryLarge $itemCategoryLarge
     * @return ItemCategoryLargeEntity
     */
    public function makeItemCategoryLarge(ItemCategoryRelationEntity $itemCategoryRelationEntity): ItemCategoryLargeEntity
    {
        return new ItemCategoryLargeEntity(
            $itemCategoryRelationEntity->itemCategoryLargeCd,
            $itemCategoryRelationEntity->itemCategoryLargeName,
        );
    }
    /**
     * ItemCategoryLargeEntity作成
     *
     * @param ItemCategoryLarge $itemCategoryLarge
     * @return ItemCategoryLargeEntity
     */
    public function make(ItemCategoryLarge $itemCategoryLarge): ItemCategoryLargeEntity
    {
        return new ItemCategoryLargeEntity(
            $itemCategoryLarge->category_large_cd,
            $itemCategoryLarge->category_large_name,
        );
    }
}
