<?php

namespace App\Domain\Repositories;

interface ItemCategoryRelationRepositoryInterface
{

    /**
     * 商品カテゴリ連携一覧の取得
     *
     * @return array
     */
    public function findItemCategoryRelationList(): array;

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 商品カテゴリ情報取得
     *
     * @param array $productCd 商品コード
     * @return array
     */
    public function getItemCategoryRelationInfo($productCd);
}
