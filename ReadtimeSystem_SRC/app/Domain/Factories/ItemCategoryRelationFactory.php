<?php
namespace App\Domain\Factories;

use App\Domain\Entities\ItemCategoryRelationEntity;
use App\Domain\Models\ItemCategoryRelation;

class ItemCategoryRelationFactory
{

    /**
     * ItemCategoryRelationEntity作成
     *
     * @param ItemCategoryRelation $itemCategoryRelation
     * @return ItemCategoryRelationEntity
     */
    public function makeItemCategoryRelation(ItemCategoryRelation $itemCategoryRelation): ItemCategoryRelationEntity
    {
        return new ItemCategoryRelationEntity(
            $itemCategoryRelation->item_category_relation_id,
            $itemCategoryRelation->category_large_cd,
            $itemCategoryRelation->category_large_name,
            $itemCategoryRelation->category_medium_cd,
            $itemCategoryRelation->category_medium_name,
            $itemCategoryRelation->item_cd,
            $itemCategoryRelation->item_name,
            $itemCategoryRelation->keicho
        );
    }
}
