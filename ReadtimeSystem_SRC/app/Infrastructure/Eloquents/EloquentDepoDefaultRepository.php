<?php

namespace App\Infrastructure\Eloquents;

use DB;
use App\Domain\Entities\DepoDefaultEntity;
use App\Domain\Factories\DepoDefaultFactory;
use App\Domain\Models\DepoDefault;
use App\Domain\Repositories\DepoDefaultRepositoryInterface;
use App\Domain\Factories\BaseFactory;
use Exception;

class EloquentDepoDefaultRepository implements DepoDefaultRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;

    /**
     * コンストラクタ
     *
     * @param DepoDefault $depoDefault
     * @param DepoDefaultFactory $depoDefaultFactory
     * @param BaseFactory $factory
     */
    public function __construct(DepoDefault $depoDefault, DepoDefaultFactory $depoDefaultFactory, BaseFactory $factory)
    {
        $this->eloquent = $depoDefault;
        $this->factory = $depoDefaultFactory;
        $this->baseFactory = $factory;
    }

    /**
     * デポカレンダー情報取得
     *
     * @param int $depocd
     * @return DepoDefaultEntity
     */
    public function findDepoDefault(int $depocd): DepoDefaultEntity
    {
        $result = null;

        $depoDefault = $this->eloquent::select(
            'depo_default.depo_default_id',
            'depo_default.depo_cd',
            'view_depo.deponame',
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
            'depo_default.handing_flg',
            'depo_default.congratulation_kbn_flg',
            'depo_default.transfer_post_depo_cd',
            'view_trans_depo.deponame as view_trans_depo',
            'depo_default.depo_lead_time',
        )
        ->leftJoin('view_depo', 'view_depo.depocd', '=', 'depo_default.depo_cd')
        ->leftJoin('view_depo AS view_trans_depo', 'view_trans_depo.depocd', '=', 'depo_default.transfer_post_depo_cd')
        ->where('view_depo.depocd', '=', $depocd)
        ->first();
        $result = $this->factory->makeDepoDefaultCalendar($depoDefault, $depocd);

        return $result;
    }

    /**
     * デポカレンダー情報の登録/更新
     *
     * @param DepoDefaultEntity $depoDefaultEntity
     * @return DepoDefaultEntity
     */
    public function saveDepoDefault(DepoDefaultEntity $depoDefaultEntity): ?DepoDefaultEntity
    {
        $result = null;
        $model = $this->eloquent::where('depo_cd', $depoDefaultEntity->depoCd)->first();
        if (!$model) {
            $model = new DepoDefault();
        }
        $model->depo_cd = $depoDefaultEntity->depoCd;
        $model->mon_before_deadline_flg = $depoDefaultEntity->monBeforeDeadlineFlg;
        $model->mon_today_delivery_flg = $depoDefaultEntity->monTodayDeliveryFlg;
        $model->tue_before_deadline_flg = $depoDefaultEntity->tueBeforeDeadlineFlg;
        $model->tue_today_delivery_flg = $depoDefaultEntity->tueTodayDeliveryFlg;
        $model->wed_before_deadline_flg = $depoDefaultEntity->wedBeforeDeadlineFlg;
        $model->wed_today_delivery_flg = $depoDefaultEntity->wedTodayDeliveryFlg;
        $model->thu_before_deadline_flg = $depoDefaultEntity->thuBeforeDeadlineFlg;
        $model->thu_today_delivery_flg = $depoDefaultEntity->thuTodayDeliveryFlg;
        $model->fri_before_deadline_flg = $depoDefaultEntity->friBeforeDeadlineFlg;
        $model->fri_today_delivery_flg = $depoDefaultEntity->friTodayDeliveryFlg;
        $model->sat_before_deadline_flg = $depoDefaultEntity->satBeforeDeadlineFlg;
        $model->sat_today_delivery_flg = $depoDefaultEntity->satTodayDeliveryFlg;
        $model->sun_before_deadline_flg = $depoDefaultEntity->sunBeforeDeadlineFlg;
        $model->sun_today_delivery_flg = $depoDefaultEntity->sunTodayDeliveryFlg;
        $model->holi_before_deadline_flg = $depoDefaultEntity->holiBeforeDeadlineFlg;
        $model->holi_before_today_delivery_flg = $depoDefaultEntity->holiBeforeTodayDeliveryFlg;
        $model->holi_deadline_flg = $depoDefaultEntity->holiDeadlineFlg;
        $model->holi_today_delivery_flg = $depoDefaultEntity->holiTodayDeliveryFlg;
        $model->holi_after_deadline_flg = $depoDefaultEntity->holiAfterDeadlineFlg;
        $model->holi_after_today_delivery_flg = $depoDefaultEntity->holiAfterTodayDeliveryFlg;
        $model->private_home_flg = $depoDefaultEntity->privateHomeFlg;
        $model->handing_flg = $depoDefaultEntity->handingFlg;
        $model->congratulation_kbn_flg = $depoDefaultEntity->congratulationKbnFlg;
        $model->transfer_post_depo_cd = $depoDefaultEntity->transferPostDepoCd;
        $model->depo_lead_time = $depoDefaultEntity->depoLeadTime;

        try {
            $saveResult = $model->save();

            if ($saveResult) {
                $result = $this->factory->makeDepoDefaultCalendar($model, $depoDefaultEntity->depoCd);
            } else {
                throw new Exception();
            }
        } catch (Exception $ex) {
            throw new Exception('カレンダーデフォルト情報の登録に失敗しました');
        }

        return $result;
    }

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 住所・商品紐づきデポ情報取得
     *
     * @param array $cond 検索条件
     * @return array
     */
    public function getAddressItemRelationInfo($cond)
    {
        $query = $this->eloquent::query();
        $query->select(
            'depo_default.depo_cd',
            'S.next_day_time_type',
            'S.is_area_today_delivery_flg',
            'S.next_day_time_deadline',
            'S.today_time_deadline1',
            'S.today_time_deadline2',
            'depo_default.private_home_flg',
            'depo_default.handing_flg',
            'depo_default.congratulation_kbn_flg',
            'depo_default.transfer_post_depo_cd',
            'depo_default.depo_lead_time',
            'LG.display_group_type',
            'LG.display_type',
            'LG.rear_stand_flg as leadtime_rear_stand_flg',
            'HD.rear_stand_flg as item_rear_stand_flg',
        );
        $query->join('depo_address_leadtime as S', function ($query) use ($cond) {
            $query->on('S.depo_cd', '=', 'depo_default.depo_cd')
                  ->where('S.pref_cd', '=', $cond->pref_cd)
                  ->where('S.siku', '=', $cond->siku)
                  ->where('S.tyou', '=', $cond->tyou);
        });
        // サブクエリ
        $join_sub = DB::table('depo_item_info as dii')
            ->select(
                'dii.depo_cd',
                'vi.keicho',
                'icm.rear_stand_flg',
            )
            ->join('view_item as vi', 'vi.item_cd', '=', 'dii.item_cd')
            ->join('item_category_relation as icr', 'icr.item_cd', '=', 'dii.item_cd')
            ->join('item_category_medium as icm', 'icm.category_medium_cd', '=', 'icr.category_medium_cd')
            ->where('dii.item_cd', $cond->item_cd);
        $query->joinSub($join_sub, 'HD', function ($join) {
            $join->on('HD.depo_cd', '=', 'depo_default.depo_cd');
        });

        // サブクエリ
        $join_sub = DB::table('view_depo as vd')
            ->select(
                'vd.depocd',
                'ldg.display_group_type',
                'ldg.display_type',
                'ldg.rear_stand_flg',
            )
            ->join('leadtime_display_group as ldg', 'ldg.display_type', '=', 'vd.display_group_type');
        if ($cond->spFlg) {
            $join_sub->where('ldg.display_type', 2);
        }
        $query->joinSub($join_sub, 'LG', function ($join) {
            $join->on('LG.depocd', '=', 'depo_default.depo_cd');
        });

        $query->where('depo_default.congratulation_kbn_flg', 3)
              ->orWhere('depo_default.congratulation_kbn_flg', 'HD.keicho');
        if ($cond->handing_flg !== null) {
            $query->where('depo_default.handing_flg', $cond->handing_flg);
        }
        if ($cond->huda == 5 || $cond->huda == 6) {
            $query->whereRaw(
                '(
                    CASE WHEN "HD"."rear_stand_flg" = true
                    THEN "LG"."rear_stand_flg" = true
                    END
                )'
            );
        }

        return $query->get()->all();
    }

    /**
     * 【C_LB_01_リードタイムマスタチェックバッチ】
     * 不要デポ情報を取得する
     *
     * @return array
     */
    public function getUnnecessaryDepo()
    {
        $query = $this->eloquent::query();
        $query->select(
            'depo_cd AS depoCd'
        );
        $query->leftJoin('view_depo', 'view_depo.depocd', '=', 'depo_default.depo_cd');
        $res = $query->whereNull('depocd')->get();

        return $res;
    }

    /**
     * デポカレンダーデフォルト情報不要データを削除する
     *
     * @param array $unnecessaryDepoList
     * @return void
     */
    public function deleteDepoDefaultUnnecessary($unnecessaryDepoList)
    {
        foreach ($unnecessaryDepoList as $value) {
            $query = $this->eloquent::query();
            $query->where('depo_cd', $value)->forceDelete();
        }
    }
}
