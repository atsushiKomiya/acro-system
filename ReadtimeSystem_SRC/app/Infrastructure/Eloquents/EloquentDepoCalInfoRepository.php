<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Models\DepoCalInfo;
use App\Domain\Repositories\DepoCalInfoRepositoryInterface;
use App\Domain\Factories\DepoCalInfoFactory;
use App\Domain\Factories\MessageDuplicationFactory;
use App\Consts\AppConst;
use App\Domain\Entities\DepoCalInfoEntity;

class EloquentDepoCalInfoRepository implements DepoCalInfoRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;
    private $messageDuplicationFactory;

    /**
     * コンストラクタ
     *
     * @param ViewDepo $viewDepo
     */
    public function __construct(DepoCalInfo $depoCalInfo, DepoCalInfoFactory $factory, MessageDuplicationFactory $messageDuplicationFactory)
    {
        $this->eloquent = $depoCalInfo;
        $this->factory = $factory;
        $this->messageDuplicationFactory = $messageDuplicationFactory;
    }

    /**
     * カレンダー情報削除
     */
    public function deleteDepoCalInfo(int $depocd, int $startDate)
    {
        $result = $this->eloquent::where('depo_cd', '=', $depocd)
        ->where('delivery_date', '>=', $startDate)
        ->forceDelete();
        return $result;
    }

    /**
     * カレンダー情報登録
     */
    public function inputDepoCalInfo($depoCalInputInfo)
    {
        $result = "";

        $depoDefaultModel = $this->eloquent::insert(
            [
                'depo_cd' => $depoCalInputInfo["depocd"],
                'delivery_date' => $depoCalInputInfo["date"],
                'before_deadline_flg' => $depoCalInputInfo["beforeDeadlineFlg"],
                'today_delivery_flg' => $depoCalInputInfo["todayDeliveryFlg"],
                'dayofweek' => $depoCalInputInfo["day"],
                'public_holiday_status' => $depoCalInputInfo["syukuStatus"],
            ]
        );

        return $result;
    }

    /**
     * カレンダー情報取得
     */
    public function getDepoCalInfo($searchParam)
    {
        $depoCd = $searchParam["searchDepocd"];
        $dateYm = $searchParam["searchYm"];
        $dateYmFirst = $dateYm . "01";
        $dateYmLast = date('Ymt', strtotime($dateYmFirst));

        $depoCalInfoFactory = $this->factory;
        $result = $this->eloquent::where('depo_cd', $depoCd)
        ->whereBetween('delivery_date', [$dateYmFirst,$dateYmLast])
        ->orderBy('delivery_date')
        ->get()
        ->map(function ($item) use ($depoCalInfoFactory) {
            return $depoCalInfoFactory->makeDepoCalInfo($item);
        })->all();

        return $result;
    }

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 【C_LI_02_リードタイムAPIサーバー】
     * 曜日祝日区分取得
     * ※お届け希望日が空の場合はAPI起動日のみで取得
     *
     * @param array $dates        [届日（日付）, API起動日]
     * @return array
     */
    public function getDepoCalInfoWeekHolidayType($dates): array
    {
        $query = $this->eloquent::query();
        $res = $query->select(
            'delivery_date',
            'dayofweek',
            'public_holiday_status'
        )
        ->selectRaw('count(*) as count')
        ->whereIn('delivery_date', $dates)
        ->groupBy('delivery_date', 'dayofweek', 'public_holiday_status')
        ->get();

        return $res->all();
    }

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 【C_LI_02_リードタイムAPIサーバー】
     * 通常デポカレンダー引き当て情報取得
     *
     * @param array $cond 検索条件
     * @param array $sysid front:C_LI_01, server:C_LI_02
     * @return array
     */
    public function getNormalDepoCalAllocationInfo($cond, $sysid = 'C_LI_01')
    {
        $query = $this->eloquent::query();
        $query->select(
            'depo_cd',
            'today_delivery_flg',
            'today_deadline_limit_time',
            'annotation_disp'
        )
        ->whereIn('depo_cd', $cond->depo_cd)
        ->where('delivery_date', $cond->api_date);

        // frontAPI
        if ($sysid == AppConst::API_SYSTEM_ID['FRONT']) {
            $query->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('today_delivery_flg', '<>', '0');
                })
                ->orWhere(function ($query) {
                    $query->where('today_delivery_flg', '0')
                          ->whereNotNull('annotation_disp');
                });
            });
        } else {
            // serverAPI
            $query->where('today_delivery_flg', '<>', '0');
        }

        return $query->get()->all();
    }

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 【C_LI_02_リードタイムAPIサーバー】
     * 通常デポ翌日カレンダー引き当て情報取得
     *
     * @param array $cond 検索条件
     * @param array $sysid front:C_LI_01, server:C_LI_02
     * @return array
     */
    public function getNormalDepoNextCalAllocationInfo($cond, $sysid = 'C_LI_01')
    {
        $query = $this->eloquent::query();
        $query->select(
            'depo_cd',
            'before_deadline_flg',
            'before_deadline_limit_time',
            'annotation_disp'
        )
        ->whereIn('depo_cd', $cond->depo_cds)
        ->where('delivery_date', $cond->delivery_date);

        // frontAPI
        if ($sysid == AppConst::API_SYSTEM_ID['FRONT']) {
            $query->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('before_deadline_flg', '<>', '0');
                })
                ->orWhere(function ($query) {
                    $query->where('before_deadline_flg', '0')
                        ->whereNotNull('annotation_disp');
                });
            });
        } else {
            // serverapi
            $query->where('before_deadline_flg', '<>', '0');
        }

        return $query->get()->all();
    }

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 【C_LI_02_リードタイムAPIサーバー】
     * サプライズデポカレンダー引き当て情報取得＿１
     *
     * @param array $cond 検索条件
     * @param array $sysid front:C_LI_01, server:C_LI_02
     * @return array
     */
    public function getSpDepoNextCalAllocationInfo($cond, $sysid = 'C_LI_01')
    {
        $query = $this->eloquent::query();
        $query->select(
            'depo_cal_info.depo_cd',
            'depo_cal_info.today_delivery_flg',
            'depo_cal_info.annotation_disp',
            'depo_cal_info.today_deadline_limit_time',
            'S.is_area_today_delivery_flg',
            'S.today_time_deadline1',
            'S.today_time_deadline2'
        )
        ->join('depo_address_leadtime as S', function ($query) use ($cond) {
            $query->on('S.depo_cd', '=', 'depo_cal_info.depo_cd')
                  ->where('S.pref_cd', '=', $cond->pref_cd)
                  ->where('S.siku', '=', $cond->siku)
                  ->where('S.tyou', '=', $cond->tyou)
                  ->where('S.is_area_today_delivery_flg', '=', true);
        })
        ->whereIn('depo_cal_info.depo_cd', $cond->depo_cds)
        ->where('depo_cal_info.delivery_date', $cond->delivery_date);

        // frontAPI
        if ($sysid == AppConst::API_SYSTEM_ID['FRONT']) {
            $query->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('depo_cal_info.today_delivery_flg', '<>', '0');
                })
                ->orWhere(function ($query) {
                    $query->where('depo_cal_info.today_delivery_flg', '0')
                        ->whereNotNull('depo_cal_info.annotation_disp');
                });
            });
        } else {
            // serverapi
            $query->where('depo_cal_info.today_delivery_flg', '<>', '0');
        }

        return $query->get()->all();
    }

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 【C_LI_02_リードタイムAPIサーバー】
     * サプライズデポカレンダー引き当て情報取得＿２
     *
     * @param array $cond 検索条件
     * @return array
     */
    public function getSpDepoNextCalAllocationInfo2($cond)
    {
        $query = $this->eloquent::query();
        $query->select(
            'depo_cal_info.depo_cd',
            'depo_cal_info.annotation_disp'
        )
        ->where('depo_cal_info.depo_cd', $cond->depo_cd)
        ->where('depo_cal_info.delivery_date', $cond->delivery_date)
        ->where('depo_cal_info.today_delivery_flg', '<>', '0');

        return $query->get()->all();
    }

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 【C_LI_02_リードタイムAPIサーバー】
     * エンタメデポカレンダー最短作業日取得
     *
     * @param array $cond 検索条件
     * @param array $sysid front:C_LI_01, server:C_LI_02
     * @return array
     */
    public function getEtmDepoCalWorkDayInfo($cond, $sysid = 'C_LI_01')
    {
        // union
        $union = $this->eloquent::query();
        $union->select(
            'delivery_date',
            'before_deadline_flg',
            'before_deadline_limit_time',
            'annotation_disp'
        )
        ->where('depo_cd', $cond->depo_cd)
        ->where('delivery_date', '>=', $cond->api_date_nextday)
        ->where('before_deadline_flg', '<>', '0')
        ->orderBy('delivery_date', 'asc')->limit(1);

        // baseクエリ
        $query = $this->eloquent::query();
        $query->select(
            'delivery_date',
            'before_deadline_flg',
            'before_deadline_limit_time',
            'annotation_disp'
        )
        ->where('depo_cd', $cond->depo_cd)
        ->where('delivery_date', '>=', $cond->api_date);

        // frontAPI
        if ($sysid == AppConst::API_SYSTEM_ID['FRONT']) {
            $query->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('before_deadline_flg', '<>', '0');
                })
                ->orWhere(function ($query) {
                    $query->where('before_deadline_flg', '0')
                        ->whereNotNull('annotation_disp');
                });
            });
        } else {
            // serverapi
            $query->where('before_deadline_flg', '<>', '0');
        }
        $query->orderBy('delivery_date', 'asc')->limit(1)
        ->unionAll($union);

        return $query->get()->all();
    }

    /**
     * デポカレンダー情報更新（承認）
     *
     * @param [type] $depoCd
     * @param [type] $deliveryDate
     * @param [type] $beforeDeadlineFlg
     * @param [type] $todayDeliveryFlg
     * @param [type] $beforeDeadlineLimitTime
     * @param [type] $todayDeadlineLimitTime
     * @param [type] $dayofweek
     * @param [type] $publicHolidayStatus
     * @param [type] $annotationDepo
     * @param [type] $annotationDisp
     * @return void
     */
    public function approvalDepoCalAprInfo($depoCd, $deliveryDate, $beforeDeadlineFlg, $todayDeliveryFlg, $beforeDeadlineLimitTime, $todayDeadlineLimitTime, $dayofweek, $publicHolidayStatus, $annotationDepo, $annotationDisp)
    {
        $this->eloquent::updateOrCreate(
            [
                'depo_cd' => $depoCd,
                'delivery_date' => $deliveryDate,
            ],
            [
                'before_deadline_flg' => $beforeDeadlineFlg,
                'today_delivery_flg' => $todayDeliveryFlg,
                'before_deadline_limit_time' => $beforeDeadlineLimitTime,
                'today_deadline_limit_time' => $todayDeadlineLimitTime,
                'dayofweek' => $dayofweek,
                'public_holiday_status' => $publicHolidayStatus,
                'annotation_depo' => $annotationDepo,
                'annotation_disp' => $annotationDisp,

            ]
        );
    }

    /**
     * カレンダー情報承認データ反映
     *
     * @param DepoCalInfoEntity $depoCalInfoEntity
     * @return void
     */
    public function approvalUpdateDepoCalInfoApi(DepoCalInfoEntity $depoCalInfoEntity)
    {
        $result = $this->eloquent
        ->updateOrCreate(
            [
                'depo_cd'                    => $depoCalInfoEntity->depoCd,
                'delivery_date'              => $depoCalInfoEntity->deliveryDate,
            ],
            [
                'before_deadline_flg'        => $depoCalInfoEntity->beforeDeadlineFlg,
                'today_delivery_flg'         => $depoCalInfoEntity->todayDeliveryFlg,
                'before_deadline_limit_time' => $depoCalInfoEntity->beforeDeadlineLimitTime,
                'today_deadline_limit_time'  => $depoCalInfoEntity->todayDeadlineLimitTime,
                'dayofweek'                  => $depoCalInfoEntity->dayofweek,
                'public_holiday_status'      => $depoCalInfoEntity->publicHolidayStatus,
                'annotation_depo'            => $depoCalInfoEntity->annotationDepo,
                'annotation_disp'            => $depoCalInfoEntity->annotationDisp
            ]
        );
        return $result;
    }

    /**
     * 【C_LB_01_リードタイムマスタチェックバッチ】
     * デポカレンダー情報不要データ削除
     *
     * @param array $unnecessaryDepoList
     * @return array
     */
    public function deleteDepoCalUnnecessary($unnecessaryDepoList)
    {
        foreach ($unnecessaryDepoList as $value) {
            $query = $this->eloquent::query();
            $query->where('depo_cd', $value)->forcedelete();
        }
    }

    /**
     * 【C_LB_03】CreanUPバッチ
     * デポカレンダ－情報削除
     * @return void
     */
    public function deleteDepoCalInfoCreanUp($criterionDate)
    {
        $query = $this->eloquent::query();
        $query->where('delivery_date', '<', $criterionDate)->forcedelete();
    }
}
