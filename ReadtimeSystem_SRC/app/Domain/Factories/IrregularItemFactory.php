<?php
namespace App\Domain\Factories;

use App\Domain\Entities\IrregularItemEntity;
use App\Domain\Models\IrregularItem;

class IrregularItemFactory
{

    /**
     * IrregularEntity作成
     *
     * @param Irregular $irregular
     * @return IrregularItemEntity
     */
    public function make(IrregularItem $irregularItem): IrregularItemEntity
    {
        $entity = new IrregularItemEntity();
        $entity->irregularItemId = $irregularItem->irregular_item_id;
        $entity->irregularId = $irregularItem->irregular_id;
        $entity->itemCategoryLargeCd = $irregularItem->item_category_large_cd;
        $entity->itemCategoryMediumCd = $irregularItem->item_category_medium_cd;
        $entity->itemCd = $irregularItem->item_cd;
        $entity->itemCategoryLargeName = $irregularItem->item_category_large_name;
        $entity->itemCategoryMediumName = $irregularItem->item_category_medium_name;
        $entity->itemName = $irregularItem->item_name;

        return $entity;
    }
}
