<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\ItemCategoryRelationRepositoryInterface;
use Illuminate\Support\Collection;

class ItemCategoryRelationUseCase
{
    // 商品カテゴリ連携マスタ
    private $iItemCategoryRelationRepository;

    /**
     * コンストラクタ
     *
     * @param ItemCategoryRelationRepositoryInterface $iItemCategoryRelationRepository
     */
    public function __construct(
        ItemCategoryRelationRepositoryInterface $iItemCategoryRelationRepository
    ) {
        $this->iItemCategoryRelationRepository = $iItemCategoryRelationRepository;
    }

    /**
     * 商品カテゴリ連携一覧取得処理
     *
     * @return integer
     */
    public function findItemCategoryRelationList(): Collection
    {
        // 表示グループ一覧取得
        $itemCategoryRelationList = $this->iItemCategoryRelationRepository->findItemCategoryRelationList();

        // key - valueに変換
        $itemCategoryRelationCollect = collect($itemCategoryRelationList)->mapWithKeys(function ($item) {
            return [$item->itemCategoryRelationId => $item];
        });

        return $itemCategoryRelationCollect;
    }
}
