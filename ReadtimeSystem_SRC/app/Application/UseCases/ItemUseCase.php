<?php

namespace App\Application\UseCases;

use App\Domain\Factories\ViewItemFactory;
use App\Domain\Repositories\ItemCategoryRelationRepositoryInterface;
use App\Domain\Repositories\ViewItemRepositoryInterface;
use Illuminate\Support\Collection;

class ItemUseCase
{
    // 商品カテゴリ中マスタ
    private $iItemCategoryRelationRepository;
    private $iViewItemRepository;

    /**
    * コンストラクタ
    *
    * @param ItemCategoryRelationRepositoryInterface $iItemCategoryRelationRepository
    */
    public function __construct(
        ItemCategoryRelationRepositoryInterface $iItemCategoryRelationRepository,
        ViewItemRepositoryInterface $iViewItemRepository
    ) {
        $this->iItemCategoryRelationRepository = $iItemCategoryRelationRepository;
        $this->iViewItemRepository = $iViewItemRepository;
    }

    /**
     * 商品一覧取得処理
     *
     * @return integer
     */
    public function findViewItemList(): Collection
    {
        // 表示グループ一覧取得
        $itemCategoryRelationList = $this->iItemCategoryRelationRepository->findItemCategoryRelationList();

        // key - valueに変換
        $itemCollect = collect($itemCategoryRelationList)
         ->unique(function ($item) {
             return $item->itemCd;
         })
         ->map(function ($item) {
             return (new ViewItemFactory)->makeViewItem($item);
         });
         
        return $itemCollect;
    }


    /**
     * 商品名一覧取得
     *
     * @return integer
     */
    public function findViewItemNameList(): array
    {
        $item = $this->iViewItemRepository->findViewItemNameList();
        return $item;
    }


    public function findViewItem($itemcd)
    {
        $item = $this->iViewItemRepository->findViewItem($itemcd);

        return $item;
    }
}
