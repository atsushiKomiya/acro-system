<?php

namespace App\Application\UseCases;

use App\Domain\Factories\ItemCategoryLargeFactory;
use App\Domain\Repositories\ItemCategoryRelationRepositoryInterface;
use App\Domain\Repositories\ItemCategoryLargeRepositoryInterface;
use Illuminate\Support\Collection;

class ItemCategoryLargeUseCase
{
    // 商品カテゴリ大マスタ
    private $iItemCategoryRelationRepository;
    private $iItemCategoryLargeRepository;

    /**
     * コンストラクタ
     *
     * @param ItemCategoryRelationRepositoryInterface $iItemCategoryRelationRepository
     * @param ItemCategoryLargeRepositoryInterface $iItemCategoryLargeRepository
     */
    public function __construct(
        ItemCategoryRelationRepositoryInterface $iItemCategoryRelationRepository,
        ItemCategoryLargeRepositoryInterface $iItemCategoryLargeRepository
    ) {
        $this->iItemCategoryRelationRepository = $iItemCategoryRelationRepository;
        $this->iItemCategoryLargeRepository = $iItemCategoryLargeRepository;
    }

    /**
     * 商品カテゴリ大一覧取得処理
     *
     * @return integer
     */
    public function findItemCategoryLargeList(): Collection
    {

        // 表示グループ一覧取得
        $itemCategoryRelationList = $this->iItemCategoryRelationRepository->findItemCategoryRelationList();

        // key - valueに変換
        $itemCategoryLargeCollect = collect($itemCategoryRelationList)
        ->unique(function ($item) {
            return $item->itemCategoryLargeCd;
        })
        ->map(function ($item) {
            return (new ItemCategoryLargeFactory)->makeItemCategoryLarge($item);
        });

        return $itemCategoryLargeCollect;
    }

    public function findItemCategoryLarge($itemLargecd)
    {
        $itemLarge = $this->iItemCategoryLargeRepository->findItemCategoryLarge($itemLargecd);

        return $itemLarge;
    }
}
