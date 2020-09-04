<?php

namespace App\Infrastructure\Eloquents;

use App\Consts\AppConst;
use App\Domain\Entities\ViewItemEntity;
use App\Domain\Factories\ViewItemFactory;
use App\Domain\Models\ViewItem;
use App\Domain\Repositories\ViewItemRepositoryInterface;

class EloquentViewItemRepository implements ViewItemRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;

    /**
     * コンストラクタ
     *
     * @param ViewItem $viewItem
     */
    public function __construct(ViewItem $viewItem, ViewItemFactory $factory)
    {
        $this->eloquent = $viewItem;
        $this->factory = $factory;
    }

    /**
     * 商品一覧の取得
     *
     * @return array
     */
    public function findViewItemList(): array
    {
        $viewItemFactory = $this->factory;
        $result = $this->eloquent::select(
            'item_cd',
            'item_name',
            'keicho',
        )
        ->distinct()
        ->where('sale_status', '=', AppConst::SALE_STATUS_ON)
        ->orderBy('item_cd')
        ->get()
        ->map(function ($item) use ($viewItemFactory) {
            return $viewItemFactory->makeViewItem($item);
        })->all();
        return $result;
    }

    /**
     * 商品名一覧の取得
     *
     * @return array
     */
    public function findViewItemNameList(): array
    {
        $viewItemFactory = $this->factory;
        $result = $this->eloquent::select(
            'item_cd',
            'item_name',
            'item_cd as keicho'
        )
        ->where('sale_status', '=', AppConst::SALE_STATUS_ON)
        ->groupBy(['item_cd','item_name'])
        ->orderBy('item_cd')
        ->get()
        ->map(function ($item) use ($viewItemFactory) {
            $item->keicho = 0;
            return $viewItemFactory->make($item);
        })->all();
        return $result;
    }

    /**
     * 商品の取得
     *
     * @return ViewItemEntity
     */
    public function findViewItem($itemCd): ?ViewItemEntity
    {
        $result = null;
        $viewItemFactory = $this->factory;
        $model = $this->eloquent::select(
            'item_cd',
            'item_name',
            'keicho',
        )
        ->where('item_cd', $itemCd)
        ->first();
        if (!is_null($model)) {
            $result = $viewItemFactory->make($model);
        }
        return $result;
    }
}
