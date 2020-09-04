<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Entities\ItemCategoryMediumEntity;
use App\Domain\Factories\ItemCategoryMediumFactory;
use App\Domain\Models\ItemCategoryMedium;
use App\Domain\Repositories\ItemCategoryMediumRepositoryInterface;

class EloquentItemCategoryMediumRepository implements ItemCategoryMediumRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;

    /**
     * コンストラクタ
     *
     * @param ItemCategoryMedium $itemCategoryMedium
     */
    public function __construct(ItemCategoryMedium $itemCategoryMedium, ItemCategoryMediumFactory $factory)
    {
        $this->eloquent = $itemCategoryMedium;
        $this->factory = $factory;
    }

    /**
     * 商品カテゴリ中一覧の取得
     *
     * @return array
     */
    public function findItemCategoryMediumList(): array
    {
        $itemCategoryMediumFactory = $this->factory;
        $result = $this->eloquent::select(
            'category_medium_cd',
            'category_medium_name',
        )
        ->distinct()
        ->orderBy('category_medium_cd')
        ->get()
        ->map(function ($item) use ($itemCategoryMediumFactory) {
            return $itemCategoryMediumFactory->makeItemCategoryMedium($item);
        })->all();

        return $result;
    }
    /**
     * 商品カテゴリ中の取得
     *
     * @return ItemCategoryMediumEntity
     */
    public function findItemCategoryMedium($categoryMediumCd): ?ItemCategoryMediumEntity
    {
        $result = null;
        $itemCategoryMediumFactory = $this->factory;
        $model = $this->eloquent::select(
            'category_medium_cd',
            'category_medium_name',
        )
        ->where('category_medium_cd', $categoryMediumCd)
        ->first();

        if (!is_null($model)) {
            $result = $itemCategoryMediumFactory->make($model);
        }
        return $result;
    }
}
