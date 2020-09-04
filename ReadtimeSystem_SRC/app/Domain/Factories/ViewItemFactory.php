<?php
namespace App\Domain\Factories;

use App\Domain\Entities\ItemCategoryRelationEntity;
use App\Domain\Entities\ViewItemEntity;
use App\Domain\Models\ViewItem;

class ViewItemFactory
{

    /**
     * ViewItemEntity作成
     *
     * @param ViewItem $viewItem
     * @return ViewItemEntity
     */
    public function makeViewItem(ItemCategoryRelationEntity $itemCategoryRelationEntity): ViewItemEntity
    {
        return new ViewItemEntity(
            $itemCategoryRelationEntity->itemCd,
            $itemCategoryRelationEntity->itemName,
            $itemCategoryRelationEntity->itemCategoryLargeCd,
            $itemCategoryRelationEntity->itemCategoryLargeName,
            $itemCategoryRelationEntity->itemCategoryMediumCd,
            $itemCategoryRelationEntity->itemCategoryMediumName,
            $itemCategoryRelationEntity->keicho
        );
    }

    /**
     * ViewItemEntity作成
     *
     * @param ViewItem $viewItem
     * @return ViewItemEntity
     */
    public function make(ViewItem $viewItem): ViewItemEntity
    {
        return new ViewItemEntity(
            $viewItem->item_cd,
            $viewItem->item_name,
            null,
            null,
            null,
            null,
            null,
            $viewItem->keicho
        );
    }

    /**
     * 商品CD、商品名称のみ設定する最小のEntityを生成する
     *
     * @param integer $itemCd
     * @param string $itemName
     * @return ViewItemEntity
     */
    public function makeItemMinimum(string $itemCd, string $itemName): ViewItemEntity
    {
        return new ViewItemEntity(
            $itemCd,
            $itemName
        );
    }
}
