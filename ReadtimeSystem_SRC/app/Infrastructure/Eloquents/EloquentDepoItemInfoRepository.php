<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Entities\DepoItemInfoEntity;
use App\Domain\Factories\DepoItemInfoFactory;
use App\Domain\Models\DepoItemInfo;
use App\Domain\Repositories\DepoItemInfoRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\LazyCollection;

class EloquentDepoItemInfoRepository implements DepoItemInfoRepositoryInterface
{
    // Model
    private $eloquent;
    // ファクトリを格納するプロパティ
    private $factory;

    /**
     * コンストラクタ
     *
     * @param DepoItemInfo $depoItemInfo
     * @param DepoItemInfoFactory $depoItemInfoFactory
     */
    public function __construct(DepoItemInfo $depoItemInfo, DepoItemInfoFactory $depoItemInfoFactory)
    {
        $this->eloquent = $depoItemInfo;
        $this->factory = $depoItemInfoFactory;
    }

    /**
     * デポ紐付けアイテム情報のベースとなるBuilderを取得する
     *
     * @param integer $depocd
     * @return Builder
     */
    private function baseSelectModel(int $depocd): Builder
    {
        $model = $this->eloquent::select(
            'depo_item_info.depo_item_info_id',
            'depo_item_info.depo_cd',
            'view_depo.deponame',
            'item_category_relation.category_large_cd AS category_large_cd',
            'item_category_large.category_large_name AS category_large_name',
            'item_category_relation.category_medium_cd AS category_medium_cd',
            'item_category_medium.category_medium_name AS category_medium_name',
            'depo_item_info.item_cd',
            'view_item.item_name',
            'depo_item_info.deleted_at'
        )
        ->join('item_category_relation', 'item_category_relation.item_cd', '=', 'depo_item_info.item_cd')
        ->join('item_category_medium', 'item_category_medium.category_medium_cd', '=', 'item_category_relation.category_medium_cd')
        ->join('item_category_large', 'item_category_large.category_large_cd', '=', 'item_category_relation.category_large_cd')
        ->join('view_item', function ($join) {
            $join->on('depo_item_info.item_cd', '=', 'view_item.item_cd');
        })
        ->join('view_depo', function ($join) {
            $join->on('view_depo.depocd', '=', 'depo_item_info.depo_cd');
        })
        ->where('depo_item_info.depo_cd', '=', $depocd)
        ->orderBy('depo_cd')
        ->orderBy('item_cd');

        return $model;
    }

    /**
     * 削除済みも含めてデポ取扱商品情報の取得
     *
     * @param integer $depocd
     * @return array
     */
    public function findDepoItemInfoDeletedAtAllList(int $depocd): array
    {
        $useFactory = $this->factory;
        $model = $this->baseSelectModel($depocd);
        $result = $model->withTrashed()
        ->get()
        ->unique(function ($item) {
            return $item->item_cd;
        })
        ->map(function ($item) use ($useFactory) {
            return $useFactory->makeSearchEntity($item);
        })
        ->values()
        ->all();

        return $result;
    }

    /**
     * デポ取扱商品情報の取得
     *
     * @param integer $depocd
     * @return array
     */
    public function findDepoItemInfoList(int $depocd): array
    {
        $useFactory = $this->factory;
        $model = $this->baseSelectModel($depocd);
        $result = $model->get()
        ->unique(function ($item) {
            return $item->item_cd;
        })
        ->map(function ($item) use ($useFactory) {
            return $useFactory->makeSearchEntity($item);
        })
        ->values()
        ->all();

        return $result;
    }

    /**
     * デポ取扱商品情報の取得（CSV）
     *
     * @param integer $depocd
     * @return LazyCollection
     */
    public function findDepoItemInfoListCsv(int $depocd): LazyCollection
    {
        $model = $this->baseSelectModel($depocd);
        $result = $model
        ->cursor()
        ->unique(function ($item) {
            return $item->item_cd;
        });

        return $result;
    }

    /**
     * デポ取扱商品情報の登録
     *
     * @param DepoItemInfoEntity $entity
     * @return boolean
     */
    public function save(DepoItemInfoEntity $entity): bool
    {
        $this->eloquent::withTrashed()->updateOrCreate(
            [
                'depo_cd' => $entity->depoCd,
                'item_cd' => $entity->itemCd,
            ],
            []
        );
        return true;
    }

    /**
     * デポ取扱商品情報の削除
     *
     * @param integer $depoItemInfoId
     * @return boolean
     */
    public function delete(int $depoItemInfoId): bool
    {
        $model = $this->eloquent::find($depoItemInfoId);
        if ($model) {
            $model->delete();
            // 更新者ID、削除IDを更新するため
            $model->save();
        }
        return true;
    }

    /**
     * デポ取扱商品情報の復元
     *
     * @param integer $depoItemInfoId
     * @return boolean
     */
    public function restore(int $depoItemInfoId): bool
    {
        $this->eloquent::withTrashed()->find($depoItemInfoId)->restore();
        return true;
    }

    /**
     * デポ取扱商品不要データ削除
     *
     * @param array $unnecessaryDepoList
     * @return void
     */
    public function deleteDepoItemUnnecessary($unnecessaryDepoList)
    {
        foreach ($unnecessaryDepoList as $value) {
            $query = $this->eloquent::withTrashed() // 論理削除済みデータも対象
                            ->where('depo_cd', $value);

            // ロックが取得できない場合はエラーにする
            $query->lock('for update nowait')->get();

            $query->forceDelete();
        }
    }

    /**
     * 商品を取り扱っているデポの一覧を取得する
     *
     * @param array $itemList
     * @return array
     */
    public function findSimilarItemDepo(array $itemList): array
    {
        $query = $this->eloquent::select(
            'depo_item_info.depo_cd'
        )
        ->join('item_category_relation', 'item_category_relation.item_cd', '=', 'depo_item_info.item_cd')
        ->join('item_category_medium', 'item_category_medium.category_medium_cd', '=', 'item_category_relation.category_medium_cd')
        ->join('item_category_large', 'item_category_large.category_large_cd', '=', 'item_category_relation.category_large_cd');

        foreach($itemList as $item) {
            $query->orWhere(function($query) use($item){
                if($item->itemCategoryLargeCd) {
                    $query->where('item_category_large.category_large_cd',$item->itemCategoryLargeCd);
                }
                if($item->itemCategoryMediumCd) {
                    $query->where('item_category_medium.category_medium_cd',$item->itemCategoryMediumCd);
                }
                if($item->itemCd) {
                    $query->where('depo_item_info.item_cd',$item->itemCd);
                }
            });
        }

        $list = $query->groupBy('depo_item_info.depo_cd')
        ->orderBy('depo_item_info.depo_cd')
        ->get()
        ->map(function($model){
            return $model->depo_cd;
        })
        ->all();
        

        return $list;

    }

}
