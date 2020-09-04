<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\ItemCategoryLargeEntity;

interface ItemCategoryLargeRepositoryInterface
{

    /**
     * 商品カテゴリ大一覧の取得
     *
     * @return array
     */
    public function findItemCategoryLargeList(): array;
    /**
     * 商品カテゴリ大の取得
     *
     * @return itemCategoryLargeEntity
     */
    public function findItemCategoryLarge(int $categoryLargeCd): ?ItemCategoryLargeEntity;
}
