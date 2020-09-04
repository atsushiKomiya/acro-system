<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Entities\ItemCategoryLargeEntity;
use App\Domain\Factories\ItemCategoryLargeFactory;
use App\Domain\Models\ItemCategoryLarge;
use App\Domain\Repositories\ItemCategoryLargeRepositoryInterface;

class EloquentItemCategoryLargeRepository implements ItemCategoryLargeRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;

    /**
     * コンストラクタ
     *
     * @param ItemCategoryLarge $itemCategoryLarge
     */
    public function __construct(ItemCategoryLarge $itemCategoryLarge, ItemCategoryLargeFactory $factory)
    {
        $this->eloquent = $itemCategoryLarge;
        $this->factory = $factory;
    }

    /**
     * 商品カテゴリ大一覧の取得
     *
     * @return array
     */
    public function findItemCategoryLargeList(): array
    {
        $itemCategoryLargeFactory = $this->factory;
        $result = $this->eloquent::select(
            'category_large_cd',
            'category_large_name',
        )
        ->distinct()
        ->orderBy('category_large_cd')
        ->get()
        ->map(function ($item) use ($itemCategoryLargeFactory) {
            return $itemCategoryLargeFactory->makeItemCategoryLarge($item);
        })->all();
        return $result;
    }

    /**
     * 商品カテゴリ大の取得
     *
     * @return ItemCategoryLargeEntity
     */
    public function findItemCategoryLarge($categoryLargeCd): ?ItemCategoryLargeEntity
    {
        $result = null;
        $itemCategoryLargeFactory = $this->factory;
        $model = $this->eloquent::select(
            'category_large_cd',
            'category_large_name',
        )
        ->where('category_large_cd', $categoryLargeCd)
        ->first();

        if (!is_null($model)) {
            $result = $itemCategoryLargeFactory->make(($model));
        }
        return $result;
    }
}
