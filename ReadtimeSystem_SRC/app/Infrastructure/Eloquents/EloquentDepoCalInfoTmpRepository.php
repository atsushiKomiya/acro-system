<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Entities\DepoCalInfoTmpEntity;
use App\Domain\Models\DepoCalInfoTmp;
use App\Domain\Repositories\DepoCalInfoTmpRepositoryInterface;
use App\Domain\Factories\DepoCalInfoTmpFactory;

class EloquentDepoCalInfoTmpRepository implements DepoCalInfoTmpRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    // private $factory;

    /**
     * コンストラクタ
     *
     * @param DepoCalInfoTmp $depoCalInfoTmp
     */
    public function __construct(DepoCalInfoTmp $depoCalInfoTmp, DepoCalInfoTmpFactory $factory)
    {
        $this->eloquent = $depoCalInfoTmp;
        $this->factory = $factory;
    }

    /**
     * カレンダーTmp情報削除
     *
     * @param [type] $depocd
     * @param [type] $deliveryDate
     * @param integer $userId
     * @return void
     */
    public function deleteDepoCalInfoTmp($depocd, $deliveryDate,int $userId)
    {
        $result = $this->eloquent::where('depo_cd', $depocd)
        ->where('delivery_date', '>=', $deliveryDate)
        ->update(
            [
            'deleted_id' => $userId,
            'deleted_at' => now()
        ]
        );

        return $result;
    }

    /**
     * カレンダー情報取得
     */
    public function getDepoCalInfoTmp($searchParam)
    {
        $depoCd = $searchParam["searchDepocd"];
        $dateYm = $searchParam["searchYm"];
        $dateYmFirst = $dateYm . "01";
        $dateYmLast = date('Y-m-t', strtotime($dateYmFirst));

        $depoCalInfoTmpFactory = $this->factory;
        $result = $this->eloquent::where('depo_cd', $depoCd)
        ->whereBetween('delivery_date', [$dateYmFirst,$dateYmLast])
        ->get()
        ->map(function ($item) use ($depoCalInfoTmpFactory) {
            return $depoCalInfoTmpFactory->makeDepoCalInfoTmp($item);
        })->all();
    }

    /**
     * 対象デポのカレンダー情報tmpを取得する
     *
     * @param string $dateYm
     * @param integer $depoCd
     * @return void
     */
    public function findTargetYmDepoCalInfoTmp(string $dateYm, int $depoCd): array
    {
        $result = $this->eloquent::where('depo_cd', $depoCd)
        ->where('delivery_date', 'LIKE', $dateYm.'%')
        ->get()
        ->all();

        return $result;
    }

    /**
     * カレンダーTmp情報取得API
     *
     * @param integer $depoCd
     * @param string $deliveryDate
     * @param integer $userId
     * @return void
     */
    public function deleteDepoCalInfoTmpApr(int $depoCd,string $deliveryDate,int $userId)
    {
        $result = $this->eloquent::where('depo_cd', $depoCd)
        ->where('delivery_date', '=', $deliveryDate)
        ->update([
            'deleted_id' => $userId,
            'deleted_at' => now()
        ]);

        return $result;
    }

    /**
     * カレンダーTmp情報取得API
     *
     * @param DepoCalInfoTmpEntity $depoCalInfoTmpEntity
     * @return void
     */
    public function saveDepoCalInfoTmpApr(DepoCalInfoTmpEntity $depoCalInfoTmpEntity)
    {
        $model = $this->eloquent::where('depo_cd', $depoCalInfoTmpEntity->depoCd)
        ->where('delivery_date', '=', $depoCalInfoTmpEntity->deliveryDate)->first();
        if(is_null($model))
        {
            $model = new DepoCalInfoTmp();
        }
        $model->depo_cd = $depoCalInfoTmpEntity->depoCd;
        $model->delivery_date = $depoCalInfoTmpEntity->deliveryDate;
        $model->before_deadline_flg = $depoCalInfoTmpEntity->beforeDeadlineFlg;
        $model->today_delivery_flg = $depoCalInfoTmpEntity->todayDeliveryFlg;
        $model->before_deadline_limit_time = $depoCalInfoTmpEntity->beforeDeadlineLimitTime;
        $model->today_deadline_limit_time = $depoCalInfoTmpEntity->todayDeadlineLimitTime;
        $model->dayofweek = $depoCalInfoTmpEntity->dayofweek;
        $model->public_holiday_status = $depoCalInfoTmpEntity->publicHolidayStatus;
        $model->annotation_depo = $depoCalInfoTmpEntity->annotationDepo;
        $result = $model->save();

        return $result;
    }

    /**
     * カレンダーTmp情報承認処理
     *
     * @param integer $depoCd
     * @param string $deliveryDate
     * @return void
     */
    public function updateDepoCalInfoTmpApi(int $depoCd,string $deliveryDate)
    {
        $result = $this->eloquent::where('depo_cd', $depoCd)
        ->where('delivery_date', '=', $deliveryDate)
        ->update([
            'approval_flg' => true
        ]);
        return $result;
    }

    /**
     * 対象デポのカレンダー情報tmpを承認する
     *
     * @param array $idList
     * @return void
     */
    public function updateDepoCalInfoTmpForIdList(array $idList)
    {
        $this->eloquent::whereIn('depo_cal_tmp_id', $idList)
        ->update([
            'approval_flg' => true
        ]);
    }

    /**
     * 不要デポのカレンダー情報tmpを削除する
     *
     * @param array $unnecessaryDepoList
     * @return void
     */
    public function deleteDepoCalTmpUnnecessary(array $unnecessaryDepoList)
    {
        foreach ($unnecessaryDepoList as $value) {
            $result = $this->eloquent::whereNull('deleted_at')
            ->where('depo_cd', $value)
            ->delete();

            return $result;
        }
    }
    

    /**
     * 対象デポのカレンダー情報tmpを取得する
     *
     * @param string $dateYm
     * @param integer $depoCd
     * @return void
     */
    public function findTargetYmDepoCalAprInfoTmp(string $dateYm, int $depoCd): array
    {
        $result = $this->eloquent::where('depo_cd', $depoCd)
        ->where('delivery_date', 'LIKE', $dateYm.'%')
        ->get()
        ->all();

        return $result;
    }

    /**
     * カレンダーTmp情報削除
     *
     * @return integer
     */
    public function deleteDepoCalAprInfoTmp($depocd, $deliveryDate)
    {
        $result = $this->eloquent::whereNull('deleted_at')
        ->where('depo_cd', $depocd)
        ->where('delivery_date', '>=', $deliveryDate)
        ->delete();

        return $result;
    }

    /**
     * 対象デポのカレンダー情報tmpを承認する
     *
     * @param array $idList
     * @return void
     */
    public function updateDepoCalAprInfoTmpForIdList(array $idList)
    {
        $this->eloquent::whereIn('depo_cal_tmp_id', $idList)
        ->update([
            'approval_flg' => true
        ]);
    }

    /**
     * 【C_LB_03】CreanUPバッチ
     * デポカレンダ－情報-tmp論理削除
     * @return void
     */
    public function deleteDepoCalInfoTmpCreanUp($criterionDate, $userId)
    {
        $query = $this->eloquent::query();
        $query->where('delivery_date', '<', $criterionDate)
        ->whereNull('deleted_at')
        ->update(
            [
                'deleted_id' => $userId,
                'deleted_at' => now()
            ]
        );
    }
}
