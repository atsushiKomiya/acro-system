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
     * 商品一覧取得処理
     *
     * @return integer
     */
    public function findViewCategoryItemList(): Collection
    {
        // 表示グループ一覧取得
        $itemCategoryRelationList = $this->iItemCategoryRelationRepository->findItemCategoryRelationList();

        $collect = collect($itemCategoryRelationList)
        ->unique(function ($item) {
            return $item->itemCd;
        })
        ->groupBy(
            [
                function ($item, $key) {
                    return $item->itemCategoryLargeName;
                },
                function ($item, $key) {
                    return $item->itemCategoryMediumName;
                },
            ], $preserveKeys = true
        );

        $list = null;
        $listno = 0;
        foreach($collect as $categoryLargeName => $all) {
            // 商品カテゴリ大名設定
            $list[$listno] = (object) [
                'itemCd' => null,
                'itemName' => null,
                'itemCategoryLargeCd' => null,
                'itemCategoryLargeName' => $categoryLargeName,
                'itemCategoryMediumCd' => null,
                'itemCategoryMediumName' => null,
                'isSelect' => false,
                'keicho' => null,
            ];
            foreach($all as $categoryMediumName => $items) {
                $listno ++;
                // 商品カテゴリ中名設定
                $list[$listno] = (object) [
                    'itemCd' => null,
                    'itemName' => null,
                    'itemCategoryLargeCd' => null,
                    'itemCategoryLargeName' => $categoryLargeName,
                    'itemCategoryMediumCd' => null,
                    'itemCategoryMediumName' => $categoryMediumName,
                    'isSelect' => false,
                    'keicho' => null,
                ];
                foreach($items as $item) {
                    $listno ++;
                    // 商品カテゴリ大コード設定
                    $list[$listno -2]->itemCategoryLargeCd = $item->itemCategoryLargeCd;
                    $list[$listno -1]->itemCategoryLargeCd = $item->itemCategoryLargeCd;
                    // 商品カテゴリ中コード設定
                    $list[$listno -1]->itemCategoryMediumCd = $item->itemCategoryMediumCd;
                    $list[$listno] = (new ViewItemFactory)->makeViewItem($item);
                }
            }
        }
        // key - valueに変換
        $itemCollect = collect($list);
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
