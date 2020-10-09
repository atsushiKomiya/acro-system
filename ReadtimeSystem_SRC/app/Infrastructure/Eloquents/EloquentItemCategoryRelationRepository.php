<?php

namespace App\Infrastructure\Eloquents;

use App\Consts\AppConst;
use App\Domain\Factories\ItemCategoryRelationFactory;
use App\Domain\Models\ItemCategoryRelation;
use App\Domain\Repositories\ItemCategoryRelationRepositoryInterface;

class EloquentItemCategoryRelationRepository implements ItemCategoryRelationRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;

    /**
     * コンストラクタ
     *
     * @param ItemCategoryRelation $itemCategoryRelation
     */
    public function __construct(ItemCategoryRelation $itemCategoryRelation, ItemCategoryRelationFactory $factory)
    {
        $this->eloquent = $itemCategoryRelation;
        $this->factory = $factory;
    }

    /**
     * 商品カテゴリ連携一覧の取得
     *
     * @return array
     */
    public function findItemCategoryRelationList(): array
    {
        $itemCategoryRelationFactory = $this->factory;
        $result = $this->eloquent::select(
            'item_category_relation.item_category_relation_id AS item_category_relation_id',
            'item_category_relation.category_large_cd AS category_large_cd',
            'item_category_large.category_large_name AS category_large_name',
            'item_category_relation.category_medium_cd AS category_medium_cd',
            'item_category_medium.category_medium_name AS category_medium_name',
            'item_category_relation.item_cd AS item_cd',
            'view_item.item_name AS item_name',
            'view_item.keicho AS keicho',
        )
        ->join('item_category_large', 'item_category_large.category_large_cd', '=', 'item_category_relation.category_large_cd')
        ->join('item_category_medium', 'item_category_medium.category_medium_cd', '=', 'item_category_relation.category_medium_cd')
        ->join('view_item', 'view_item.item_cd', '=', 'item_category_relation.item_cd')
        ->where('view_item.sale_status', '=', AppConst::SALE_STATUS_ON)
        ->orderBy('item_category_relation.category_large_cd')
        ->orderBy('item_category_relation.category_medium_cd')
        ->orderBy('item_category_relation.item_category_relation_id')
        ->distinct()
        ->get()
        ->map(function ($item) use ($itemCategoryRelationFactory) {
            return $itemCategoryRelationFactory->makeItemCategoryRelation($item);
        })->all();
        return $result;
    }

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 商品カテゴリ情報取得
     *
     * @param array $productCd 商品コード
     * @return array
     */
    public function getItemCategoryRelationInfo($productCd)
    {
        $query = $this->eloquent::query();
        $res = $query->select(
            'category_large_cd',
            'category_medium_cd'
        )
        ->where('item_cd', $productCd)
        ->get();

        return $res->all();
    }
}
