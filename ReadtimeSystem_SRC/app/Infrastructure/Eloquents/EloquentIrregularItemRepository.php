<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Entities\IrregularItemEntity;
use App\Domain\Factories\IrregularItemFactory;
use App\Domain\Models\IrregularItem;
use App\Domain\Repositories\IrregularItemRepositoryInterface;

class EloquentIrregularItemRepository implements IrregularItemRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;

    /**
     * コンストラクタ
     *
     * @param Irregular $irregular
     */
    public function __construct(IrregularItem $irregularItem, IrregularItemFactory $factory)
    {
        $this->eloquent = $irregularItem;
        $this->factory = $factory;
    }

    /**
     * イレギュラー設定の取得
     *
     * @return array
     */
    public function findIrregularItem($irregularId): array
    {
        $irregularItemFactory = $this->factory;
        $result = $this->eloquent::select(
            'irregular_item.irregular_item_id AS irregular_item_id',
            'irregular_item.lcat_cd AS item_category_large_cd',
            'irregular_item.mcat_cd AS item_category_medium_cd',
            'irregular_item.item_cd AS item_cd',
            'irregular_item.created_id AS created_id',
            'irregular_item.created_at AS created_at',
            'irregular_item.updated_id AS updated_id',
            'irregular_item.updated_at AS updated_at',
            'item_category_large.category_large_name AS item_category_large_name',
            'item_category_medium.category_medium_name AS item_category_medium_name',
            'view_item.item_name AS item_name'
        )
    ->join('item_category_large', 'item_category_large.category_large_cd', '=', 'irregular_item.lcat_cd')
    ->join('item_category_medium', 'item_category_medium.category_medium_cd', '=', 'irregular_item.mcat_cd')
    ->join('view_item', 'view_item.item_cd', '=', 'irregular_item.item_cd')
    ->where('irregular_id', $irregularId)
    ->get()
    ->map(function ($item) use ($irregularItemFactory) {
        return $irregularItemFactory->make($item);
    })->all();

        return $result;
    }

    /**
     * イレギュラー設定
     *
     * @param IrregularItemEntity $entity
     * @return void
     */
    public function save(IrregularItemEntity $entity)
    {
        $irregularItem = $this->eloquent::find($entity->irregularItemId);

        if (is_null($irregularItem)) {
            $irregularItem = new IrregularItem();
        }

        $irregularItem->irregular_id = $entity->irregularId;
        $irregularItem->lcat_cd = $entity->itemCategoryLargeCd;
        $irregularItem->mcat_cd = $entity->itemCategoryMediumCd;
        $irregularItem->item_cd = $entity->itemCd;

        $irregularItem->save();
    }

    /**
     * イレギュラー商品削除（PK）
     *
     * @param integer $irregularItemId
     * @param integer $loginCd
     * @return void
     */
    public function deleteById(int $irregularItemId, int $loginCd)
    {
        $model = $this->eloquent::where('irregular_item_id', $irregularItemId)
        ->update([
            'deleted_id' => $loginCd,
            'deleted_at' => now()
        ]);
        
        return $model;
    }
    
    /**
     * イレギュラー商品削除（IrregularId）
     *
     * @param  $irregularId
     * @return void
     */
    public function deleteByIrregularId(int $irregularId, int $loginCd)
    {
        $model = $this->eloquent::where('irregular_id', $irregularId)
        ->update([
            'deleted_id' => $loginCd,
            'deleted_at' => now()
        ]);
        
        return $model;
    }
}
