<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Entities\DefaultLeadtimeEntity;
use App\Domain\Entities\DepoPrefEntity;
use App\Domain\Factories\DepoAddressLeadtimeFactory;
use App\Domain\Models\DepoAddressLeadtime;
use App\Domain\Repositories\DepoAddressLeadtimeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use stdClass;

class EloquentDepoAddressLeadtimeRepository implements DepoAddressLeadtimeRepositoryInterface
{
    // Model
    private $eloquent;

    /**
     * コンストラクタ
     *
     * @param DepoAddressLeadtime $depoAddressLeadtime
     */
    public function __construct(DepoAddressLeadtime $depoAddressLeadtime)
    {
        $this->eloquent = $depoAddressLeadtime;
    }

    /**
     * デポ紐付き都道府県リスト取得
     *
     * @param integer $depoCd
     * @return LazyCollection
     */
    public function findDepoPrefCollection(int $depoCd): LazyCollection
    {
        $result = $this->eloquent->select(
            'depo_address_leadtime.depo_cd',
            'depo_address_leadtime.pref_cd',
            'view_address.pref_name',
            DB::raw('count(*) as total')
        )
        ->join('view_address', function ($join) {
            $join->on('depo_address_leadtime.pref_cd', '=', 'view_address.pref');
            $join->on('depo_address_leadtime.siku', '=', 'view_address.siku');
            $join->on('depo_address_leadtime.tyou', '=', 'view_address.tyou');
        })
        ->where('depo_address_leadtime.depo_cd', $depoCd)
        ->groupBy(
            'depo_address_leadtime.depo_cd',
            'depo_address_leadtime.pref_cd',
            'view_address.pref_name',
        )
        ->orderBy('depo_address_leadtime.pref_cd')
        ->cursor();

        return $result;
    }

    /**
     * リードタイム情報SQLを取得する
     *
     * @param integer $depocd
     * @param integer $pref
     * @return void
     */
    private function getLeadtimeSql(int $depocd, ?int $pref)
    {
        $sql = $this->eloquent::select(
            'depo_address_leadtime.depo_address_leadtime_id',
            'depo_address_leadtime.depo_cd',
            'view_depo.deponame',
            'view_address.addrcd',
            'view_address.jiscode',
            'depo_address_leadtime.zip_cd',
            'depo_address_leadtime.pref_cd',
            'view_address.pref_name',
            'depo_address_leadtime.siku',
            'depo_address_leadtime.tyou',
            'depo_address_leadtime.next_day_time_type',
            'depo_address_leadtime.is_area_today_delivery_flg',
            'depo_address_leadtime.next_day_time_deadline',
            'depo_address_leadtime.today_time_deadline1',
            'depo_address_leadtime.today_time_deadline2',
        )
        ->join('view_address', function ($join) {
            $join->on('depo_address_leadtime.pref_cd', '=', 'view_address.pref');
            $join->on('depo_address_leadtime.jiscode', '=', 'view_address.jiscode');
            $join->on('depo_address_leadtime.tyou', '=', 'view_address.tyou');
        })
        ->join('view_depo', function ($join) {
            $join->on('view_depo.depocd', '=', 'depo_address_leadtime.depo_cd');
        })
        ->where('depo_address_leadtime.depo_cd', $depocd);

        // 都道府県がパラメータに存在する場合
        if ($pref !== 0 && !is_null($pref)) {
            $sql = $sql->where('depo_address_leadtime.pref_cd', $pref);
        }
        
        $collection = $sql
        ->distinct()
        ->orderBy('view_address.addrcd');

        return $collection;
    }

    /**
     * 削除済みのリードタイム情報も含めて取得する
     *
     * @param integer $depocd
     * @param integer $pref
     * @return array
     */
    public function findDepoLeadtimeAddressDeletedAtAllList(int $depocd, ?int $pref): array
    {
        $result = [];
        $sql = $this->eloquent::withTrashed()
        ->select(
            'depo_address_leadtime.depo_address_leadtime_id',
            'depo_address_leadtime.depo_cd',
            'depo_address_leadtime.zip_cd',
            'depo_address_leadtime.pref_cd',
            'depo_address_leadtime.jiscode',
            'depo_address_leadtime.siku',
            'depo_address_leadtime.tyou',
            'view_address.addrcd',
            'depo_address_leadtime.tyou',
            'depo_address_leadtime.deleted_at',
        )
        ->join('view_address', function ($join) {
            $join->on('depo_address_leadtime.pref_cd', '=', 'view_address.pref');
            $join->on('depo_address_leadtime.jiscode', '=', 'view_address.jiscode');
            $join->on('depo_address_leadtime.tyou', '=', 'view_address.tyou');
        })
        ->where('depo_address_leadtime.depo_cd', $depocd);

        // 都道府県がパラメータに存在する場合
        if (!is_null($pref)) {
            $sql = $sql->where('depo_address_leadtime.pref_cd', $pref);
        }

        $list =  $sql->distinct()
        ->orderBy('view_address.addrcd')
        ->cursor();

        $factory = new DepoAddressLeadtimeFactory();
        foreach ($list as $address) {
            $result[] = $factory->makeDefaultLeadtime($address);
        }


        return $result;
    }

    /**
     * リードタイム情報の取得
     *
     * @param integer $depocd
     * @param integer $pref
     * @return array
     */
    public function findLeadtimeAddressList(int $depocd, ?int $pref): array
    {
        $result = [];
        $factory = new DepoAddressLeadtimeFactory();
        $model = $this->getLeadtimeSql($depocd, $pref);

        $model->chunk(1000, function ($leadtimeList) use ($factory, &$result) {
            foreach ($leadtimeList as $leadtime) {
                $result[] = $factory->makeDefaultLeadtime($leadtime);
            }
        });

        return $result;
    }


    /**
     * リードタイム情報の取得（CSV）
     *
     * @param integer $depocd
     * @param integer $pref
     * @return array
     */
    public function findLeadtimeAddressListCsv(int $depocd, ?int $pref): LazyCollection
    {
        $model = $this->getLeadtimeSql($depocd, $pref);
        $result = $model->cursor();

        return $result;
    }

    /**
     * デポ住所紐付け用のリードタイムアドレス一覧を取得する
     *
     * @return array
     */
    public function findDepoAddressListCursor(int $depocd, ?int $pref): LazyCollection
    {
        $sql = $this->eloquent::select(
            'view_address.addrcd',
            'view_address.jiscode',
            'depo_address_leadtime.zip_cd as zipcode',
            'depo_address_leadtime.pref_cd as prefCd',
            'view_address.pref_name as prefName',
            'depo_address_leadtime.siku',
            'depo_address_leadtime.tyou',
        )
        ->join('view_address', function ($join) {
            $join->on('depo_address_leadtime.pref_cd', '=', 'view_address.pref');
            $join->on('depo_address_leadtime.jiscode', '=', 'view_address.jiscode');
            $join->on('depo_address_leadtime.tyou', '=', 'view_address.tyou');
        })
        ->where('depo_address_leadtime.depo_cd', $depocd);

        // 都道府県がパラメータに存在する場合
        if (!is_null($pref)) {
            $sql = $sql->where('depo_address_leadtime.pref_cd', $pref);
        }

        $result = $sql->distinct()
        ->orderBy('zipcode')
        ->cursor();

        return $result;
    }

    /**
     * リードタイム情報の取得（CSV）
     *
     * @param DefaultLeadtimeEntity $entity
     * @return void
     */
    public function upsert(DefaultLeadtimeEntity $entity)
    {
        $this->eloquent::updateOrCreate(
            [
                'depo_cd' => $entity->depoCd,
                'pref_cd' => $entity->prefCd,
                'siku' => $entity->siku,
                'tyou' => $entity->tyou,
            ],
            [
                'jiscode' => $entity->jiscode,
                'zip_cd' => $entity->zipCd,
                'next_day_time_type' => $entity->nextDayTimeType,
                'is_area_today_delivery_flg' => $entity->isAreaTodayDeliveryFlg,
                'next_day_time_deadline' => $entity->nextDayTimeDeadline,
                'today_time_deadline1' => $entity->todayTimeDeadline1,
                'today_time_deadline2' => $entity->todayTimeDeadline2,
            ]
        );
    }

    /**
     * 住所紐付けCSVアップロード時のリードタイム情報の登録
     *
     * @param DefaultLeadtimeEntity $entity
     * @return void
     */
    public function addressCsvUploadSave(DefaultLeadtimeEntity $entity)
    {
        $model = $this->eloquent->firstOrCreate(
            [
                'depo_cd' => $entity->depoCd,
                'pref_cd' => $entity->prefCd,
                'siku' => $entity->siku,
                'tyou' => $entity->tyou,
            ],
            [
                'jiscode' => $entity->jiscode,
                'zip_cd' => $entity->zipCd,
            ]
        );

        return $model;
    }

    /**
     * デポ住所コード紐付け画面からの登録
     *
     * @param DefaultLeadtimeEntity $entity
     * @return boolean
     */
    public function create(DefaultLeadtimeEntity $entity): bool
    {
        $this->eloquent::create(
            [
                'depo_cd' => $entity->depoCd,
                'zip_cd' => $entity->zipCd,
                'pref_cd' => $entity->prefCd,
                'jiscode' => $entity->jiscode,
                'siku' => $entity->siku,
                'tyou' => $entity->tyou,
            ]
        );
        return true;
    }

    /**
     * デポ住所コード紐付けからの登録
     *
     * @param DefaultLeadtimeEntity $entity
     * @return boolean
     */
    public function save(DefaultLeadtimeEntity $entity): bool
    {
        $model = $this->eloquent::where('depo_address_leadtime_id', $entity->depoAddressLeadtimeId)->first();
        if(is_null($model))
        {
            $model = new DepoAddressLeadtime();
        }
        $model->next_day_time_type = $entity->nextDayTimeType;
        $model->is_area_today_delivery_flg = $entity->isAreaTodayDeliveryFlg;
        $model->next_day_time_deadline = $entity->nextDayTimeDeadline;
        $model->today_time_deadline1 = $entity->todayTimeDeadline1;
        $model->today_time_deadline2 = $entity->todayTimeDeadline2;
        $model->save();
        return true;
    }

    /**
     * デポ住所コード紐付け画面からの復元
     *
     * @param integer $depoAddressLeadtimeId
     * @return boolean
     */
    public function restore(int $depoAddressLeadtimeId): bool
    {
        $this->eloquent::withTrashed()->find($depoAddressLeadtimeId)->restore();
        return true;
    }

    /**
     * デポ住所コード紐付け画面からの削除
     *
     * @param integer $depoAddressLeadtimeId
     * @return boolean
     */
    public function delete(int $depoAddressLeadtimeId): bool
    {
        $model = $this->eloquent::find($depoAddressLeadtimeId);
        if ($model) {
            $model->delete();
            // 更新者ID、削除IDを更新するため
            $model->save();
        }
        return true;
    }

    /**
     * デポ住所リードタイム情報不要データ削除
     *
     * @param array $unnecessaryDepoList
     * @return void
     */
    public function deleteDepoAddressUnnecessary($unnecessaryDepoList)
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
     * 住所を取り扱っているデポの一覧を取得する
     *
     * @param array $addressList
     * @return array
     */
    public function findSimilarAddressDepo(array $addressList): array
    {
        $query = $this->eloquent::select(
            'depo_address_leadtime.depo_cd'
        );

        foreach($addressList as $address) {
            $query->orWhere(function($query) use($address){
                if($address->pref) {
                    $query->where('depo_address_leadtime.pref_cd',$address->pref);
                }
                if($address->siku) {
                    $query->where('depo_address_leadtime.siku',$address->siku);
                }
                if($address->tyou) {
                    $query->where('depo_address_leadtime.tyou',$address->tyou);
                }
            });
        }

        $list = $query->groupBy('depo_address_leadtime.depo_cd')
        ->orderBy('depo_address_leadtime.depo_cd')
        ->get()
        ->map(function($model){
            return $model->depo_cd;
        })
        ->all();

        return $list;

    }

}
