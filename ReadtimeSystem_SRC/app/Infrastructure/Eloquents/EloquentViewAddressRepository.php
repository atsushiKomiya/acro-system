<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Entities\ViewAddressEntity;
use App\Domain\Factories\ViewAddressFactory;
use App\Domain\Factories\DepoDefaultListFactory;
use App\Domain\Models\ViewAddress;
use App\Domain\Repositories\ViewAddressRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class EloquentViewAddressRepository implements ViewAddressRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;

    /**
     * コンストラクタ
     *
     * @param ViewAddress $viewAddress
     * @param ViewAddressFactory $viewAddressFactory
     */
    public function __construct(
        ViewAddress $viewAddress,
        ViewAddressFactory $factory
    ) {
        $this->eloquent = $viewAddress;
        $this->factory = $factory;
    }

    /**
     * 都道府県一覧の取得
     *
     * @return array
     */
    public function findPrefList(): array
    {
        $addressFactory = $this->factory;
        $result = $this->eloquent::select(
            'pref',
            'pref_name',
        )
        ->distinct()
        ->orderBy('pref')
        ->get()
        ->map(function ($item) use ($addressFactory) {
            return $addressFactory->makePref($item);
        })->all();
        return $result;
    }

    /**
     * 都道府県の取得
     *
     * @return ViewAddressEntity
     */
    public function findPref($pref): ViewAddressEntity
    {
        $result = null;
        
        $model = $this->eloquent::select(
            'pref',
            'pref_name',
        )
        ->where('pref', $pref)
        ->first();

        if (!is_null($model)) {
            $result = $this->factory->makePref($model);
        }

        return $result;
    }

    /**
     * 市区郡一覧の取得
     *
     * @return array
     */
    public function findCityList(): array
    {
        $addressFactory = $this->factory;
        $result = $this->eloquent::select(
            'jiscode',
            'pref',
            'pref_name',
            'siku'
        )
        ->distinct()
        ->orderBy('siku')
        ->get()
        ->map(function ($item) use ($addressFactory) {
            return $addressFactory->makeCity($item);
        })->all();
        return $result;
    }

    /**
     * 住所一覧の取得
     *
     * @return array
     */
    public function findAddressList($selectCity): array
    {
        $addressFactory = $this->factory;
        $result = $this->eloquent::select(
            'addrcd',
            'jiscode',
            'zipcode',
            'pref',
            'pref_name',
            'siku',
            'tyou'
        )
        ->where('jiscode', $selectCity)
        ->distinct()
        ->orderBy('zipcode')
        ->get()
        ->map(function ($item) use ($addressFactory) {
            return $addressFactory->makeAddress($item);
        })->values()->all();
        
        return $result;
    }

    /**
     * 都道府県住所一覧の取得
     *
     * @return LazyCollection
     */
    public function findPrefAddressList($pref): LazyCollection
    {
        $result = $this->eloquent::select(
            'addrcd',
            'jiscode',
            'zipcode',
            'pref as prefCd',
            'pref_name as prefName',
            'siku',
            'tyou'
        )
        ->where('pref', $pref)
        ->distinct()
        ->orderBy('zipcode')
        ->cursor();
        
        return $result;
    }

    /**
     * 住所を一意に特定する
     *
     * @param [type] $prefCd
     * @param [type] $siku
     * @param [type] $tyou
     * @return ViewAddressEntity
     */
    public function findAddress($prefCd,$siku,$tyou): ?ViewAddressEntity
    {
        $result = null;
        $model = $this->eloquent->where(
            'pref','=',$prefCd
        )->where(
            'siku','=',$siku
        )->where(
            'tyou','=',$tyou
        )->first();

        if($model) {
            $result = (new ViewAddressFactory())->makeAddress($model);
        }

        return $result;
    }


    /**
     * デフォルト一覧の取得
     *
     * @return LazyCollection
     */
    public function findDepoDefaultList(
        $pref,
        $depoCd,
        $itemCategoryLargecd,
        $itemCategoryMediumcd,
        $itemCd,
        $isConfig
    ): LazyCollection {
        // メインQuery
        $query = $this->eloquent::select(
            'view_address.addrcd',
            'view_address.jiscode',
            'view_address.zipcode',
            'view_address.pref',
            'view_address.siku',
            'view_address.tyou',
            'view_depo1.deponame as deponame1',
            'depo_address_leadtime.depo_cd',
            'depo_address_leadtime.next_day_time_type',
            'depo_address_leadtime.is_area_today_delivery_flg',
            'depo_address_leadtime.next_day_time_deadline',
            'depo_address_leadtime.today_time_deadline1',
            'depo_address_leadtime.today_time_deadline2',
            'depo_default.mon_before_deadline_flg',
            'depo_default.mon_today_delivery_flg',
            'depo_default.tue_before_deadline_flg',
            'depo_default.tue_today_delivery_flg',
            'depo_default.wed_before_deadline_flg',
            'depo_default.wed_today_delivery_flg',
            'depo_default.thu_before_deadline_flg',
            'depo_default.thu_today_delivery_flg',
            'depo_default.fri_before_deadline_flg',
            'depo_default.fri_today_delivery_flg',
            'depo_default.sat_before_deadline_flg',
            'depo_default.sat_today_delivery_flg',
            'depo_default.sun_before_deadline_flg',
            'depo_default.sun_today_delivery_flg',
            'depo_default.holi_before_deadline_flg',
            'depo_default.holi_before_today_delivery_flg',
            'depo_default.holi_deadline_flg',
            'depo_default.holi_today_delivery_flg',
            'depo_default.holi_after_deadline_flg',
            'depo_default.holi_after_today_delivery_flg',
            'depo_default.private_home_flg',
            'depo_default.congratulation_kbn_flg',
            'depo_default.transfer_post_depo_cd',
            'view_depo2.deponame as deponame2',
            'depo_default.depo_lead_time',
        )
        ->distinct()
        ->leftJoin('depo_address_leadtime', function ($join) {
            $join->on('view_address.pref', '=', 'depo_address_leadtime.pref_cd');
            $join->on('view_address.siku', '=', 'depo_address_leadtime.siku');
            $join->on('view_address.tyou', '=', 'depo_address_leadtime.tyou');
        })
        ->leftJoin('depo_default', function ($join) {
            $join->on('depo_default.depo_cd', '=', 'depo_address_leadtime.depo_cd');
        })
        ->leftJoin('view_depo as view_depo1', function ($join) {
            $join->on('view_depo1.depocd', '=', 'depo_address_leadtime.depo_cd');
        })
        ->leftJoin('view_depo as view_depo2', function ($join) {
            $join->on('view_depo2.depocd', '=', 'depo_default.transfer_post_depo_cd');
        });
        if ($pref) {
            $query->where('view_address.pref', $pref);
        }
        if ($depoCd) {
            $query->where('depo_address_leadtime.depo_cd', $depoCd);
        }
        if ($itemCategoryLargecd || $itemCategoryMediumcd || $itemCd) {

            // カレンダー情報一時テーブル Query
            $itemQuery = DB::table('depo_item_info')->select(
                'depo_item_info.depo_cd'
            )->join('item_category_relation', function ($join) {
                $join->on('item_category_relation.item_cd', '=', 'depo_item_info.item_cd');
            })->distinct();

            if ($depoCd) {
                $itemQuery->where('depo_item_info.depo_cd', $depoCd);
            }
            if($itemCategoryLargecd) {
                $itemQuery->where('item_category_relation.category_large_cd', $itemCategoryLargecd);
            }
            if($itemCategoryMediumcd) {
                $itemQuery->where('item_category_relation.category_medium_cd', $itemCategoryMediumcd);
            }
            if($itemCd) {
                $itemQuery->where('item_category_relation.item_cd', $itemCd);
            }

            // メインQueryに組み込み
            $query->joinSub($itemQuery, 'depo_item_info', function ($join) {
                $join->on('depo_item_info.depo_cd', '=', 'depo_address_leadtime.depo_cd');
            });
        }
        if ($isConfig) {
            $query->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('depo_address_leadtime.next_day_time_deadline', '0');
                    $query->where('depo_address_leadtime.next_day_time_type', '0');
                    $query->where('depo_address_leadtime.is_area_today_delivery_flg', false);
                    $query->where('depo_address_leadtime.today_time_deadline1', '0');
                    $query->where('depo_address_leadtime.today_time_deadline2', '0');
                })->orWhereNull('depo_default.depo_cd');
            });
        }

        $query->orderBy('view_address.zipcode', 'ASC')
        ->orderBy('view_address.addrcd', 'ASC')
        ->orderBy('depo_address_leadtime.depo_cd', 'ASC');
        $result = $query->cursor();

        return $result;
    }
}
