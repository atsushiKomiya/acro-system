<?php

namespace App\Application\UseCases;

use App\Domain\Factories\ItemCategoryMediumFactory;
use App\Domain\Repositories\ItemCategoryRelationRepositoryInterface;
use App\Domain\Repositories\ItemCategoryMediumRepositoryInterface;
use Illuminate\Support\Collection;

class ItemCategoryMediumUseCase
{
    // 商品カテゴリ中マスタ
    private $iItemCategoryRelationRepository;
    private $iItemCategoryMediumRepository;

    /**
     * コンストラクタ
     *
     * @param ItemCategoryRelationRepositoryInterface $iItemCategoryRelationRepository
     */
    public function __construct(
        ItemCategoryRelationRepositoryInterface $iItemCategoryRelationRepository,
        ItemCategoryMediumRepositoryInterface $iItemCategoryMediumRepository
    ) {
        $this->iItemCategoryRelationRepository = $iItemCategoryRelationRepository;
        $this->iItemCategoryMediumRepository = $iItemCategoryMediumRepository;
    }

    /**
     * 商品カテゴリ中一覧取得処理
     *
     * @return integer
     */
    public function findItemCategoryMediumList(): Collection
    {
        // 表示グループ一覧取得
        $itemCategoryRelationList = $this->iItemCategoryRelationRepository->findItemCategoryRelationList();

        // key - valueに変換
        $itemCategoryMediumCollect = collect($itemCategoryRelationList)
        ->unique(function ($item) {
            return $item->itemCategoryMediumCd;
        })
        ->map(function ($item) {
            return (new ItemCategoryMediumFactory)->makeItemCategoryMedium($item);
        });
        
        return $itemCategoryMediumCollect;
    }

    public function findItemCategoryMedium($itemMediumcd)
    {
        $itemMedium = $this->iItemCategoryMediumRepository->findItemCategoryMedium($itemMediumcd);
        
        return $itemMedium;
    }
}
