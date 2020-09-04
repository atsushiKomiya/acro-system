<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\ItemCategoryMediumEntity;

interface ItemCategoryMediumRepositoryInterface
{

    /**
     * 商品カテゴリ中一覧の取得
     *
     * @return array
     */
    public function findItemCategoryMediumList(): array;
    /**
     * 商品カテゴリ中の取得
     *
     * @return ViewItemCategoryMediumEntity
     */
    public function findItemCategoryMedium(int $categoryMediumCd): ?ItemCategoryMediumEntity;
}
