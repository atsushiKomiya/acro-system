<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\ViewItemEntity;

interface ViewItemRepositoryInterface
{

    /**
     * 商品一覧の取得
     *
     * @return array
     */
    public function findViewItemList(): array;
    /**
     * 商品名一覧の取得
     *
     * @return array
     */
    public function findViewItemNameList(): array;
    /**
     * 商品の取得
     *
     * @return ViewItemEntity
     */
    public function findViewItem(String $itemCd): ?ViewItemEntity;
}
