<?php
namespace App\Domain\Factories;

use App\Domain\Entities\DefaultLeadtimeEntity;
use Illuminate\Database\Eloquent\Model;

class DepoAddressLeadtimeFactory
{

    /**
     * リードタイムアドレス情報EntityをModelから生成する
     *
     * @param Model $model
     * @return DefaultLeadtimeEntity
     */
    public function makeDefaultLeadtime(Model $model): DefaultLeadtimeEntity
    {
        $entity = new DefaultLeadtimeEntity();
        $entity->depoAddressLeadtimeId = $model->depo_address_leadtime_id;
        $entity->depoCd = $model->depo_cd;
        $entity->addrcd = $model->addrcd;
        $entity->jiscode = $model->jiscode;
        $entity->zipCd = $model->zip_cd;
        $entity->prefCd = $model->pref_cd;
        $entity->prefName = $model->pref_name;
        $entity->siku = $model->siku;
        $entity->tyou = $model->tyou;
        $entity->nextDayTimeType = $model->next_day_time_type;
        $entity->isAreaTodayDeliveryFlg = $model->is_area_today_delivery_flg;
        $entity->nextDayTimeDeadline = $model->next_day_time_deadline;
        $entity->todayTimeDeadline1 = $model->today_time_deadline1;
        $entity->todayTimeDeadline2 = $model->today_time_deadline2;

        return $entity;
    }

    /**
     * リードタイム情報画面からの登録時に使用するEntityを作成する
     *
     * @param [type] $depoAddressLeadtimeId
     * @param [type] $nextDayTimeType
     * @param [type] $isAreaTodayDeliveryFlg
     * @param [type] $nextDayTimeDeadline
     * @param [type] $todayTimeDeadline1
     * @param [type] $todayTimeDeadline2
     * @return DefaultLeadtimeEntity
     */
    public function makeUpdate(
        $depoAddressLeadtimeId,
        $nextDayTimeType,
        $isAreaTodayDeliveryFlg,
        $nextDayTimeDeadline,
        $todayTimeDeadline1,
        $todayTimeDeadline2
    ): DefaultLeadtimeEntity {

        $entity = new DefaultLeadtimeEntity();
        $entity->depoAddressLeadtimeId = $depoAddressLeadtimeId;
        $entity->nextDayTimeType = $nextDayTimeType;
        $entity->isAreaTodayDeliveryFlg = $isAreaTodayDeliveryFlg;
        $entity->nextDayTimeDeadline = $nextDayTimeDeadline;
        $entity->todayTimeDeadline1 = $todayTimeDeadline1;
        $entity->todayTimeDeadline2 = $todayTimeDeadline2;

        return $entity;
    }

    /**
     * デポ住所コード紐付け画面からの登録時に使用するEntityを作成する
     *
     * @param [type] $depoAddressLeadtimeId
     * @param [type] $depoCd
     * @param [type] $zipCd
     * @param [type] $prefCd
     * @param [type] $jiscode
     * @param [type] $siku
     * @param [type] $tyou
     * @return DefaultLeadtimeEntity
     */
    public function makeUpdateForDepoAddress(
        $depoAddressLeadtimeId,
        $depoCd,
        $zipCd,
        $prefCd,
        $jiscode,
        $siku,
        $tyou
    ): DefaultLeadtimeEntity {
        
        $entity = new DefaultLeadtimeEntity();
        $entity->depoAddressLeadtimeId = $depoAddressLeadtimeId;
        $entity->depoCd = $depoCd;
        $entity->jiscode = $jiscode;
        $entity->zipCd = $zipCd;
        $entity->prefCd = $prefCd;
        $entity->siku = $siku;
        $entity->tyou = $tyou;

        return $entity;
    }

    /**
     * リードタイムアドレス情報テーブル保存用のEntityを作成する
     *
     * @param [type] $depoAddressLeadtimeId
     * @param [type] $depoCd
     * @param [type] $zipCd
     * @param [type] $addrcd
     * @param [type] $jiscode
     * @param [type] $prefCd
     * @param [type] $siku
     * @param [type] $tyou
     * @param [type] $nextDayTimeType
     * @param [type] $isAreaTodayDeliveryFlg
     * @param [type] $nextDayTimeDeadline
     * @param [type] $todayTimeDeadline1
     * @param [type] $todayTimeDeadline2
     * @return DefaultLeadtimeEntity
     */
    public function makeDefaultLeadtimeCsv(
        $depoAddressLeadtimeId,
        $depoCd,
        $zipCd,
        $addrcd,
        $jiscode,
        $prefCd,
        $siku,
        $tyou,
        $nextDayTimeType,
        $isAreaTodayDeliveryFlg,
        $nextDayTimeDeadline,
        $todayTimeDeadline1,
        $todayTimeDeadline2
    ): DefaultLeadtimeEntity {
        
        $entity = new DefaultLeadtimeEntity();
        $entity->depoAddressLeadtimeId = $depoAddressLeadtimeId;
        $entity->depoCd = $depoCd;
        $entity->jiscode = $jiscode;
        $entity->zipCd = $zipCd;
        $entity->prefCd = $prefCd;
        $entity->siku = $siku;
        $entity->tyou = $tyou;
        $entity->nextDayTimeType = $nextDayTimeType;
        $entity->isAreaTodayDeliveryFlg = $isAreaTodayDeliveryFlg;
        $entity->nextDayTimeDeadline = $nextDayTimeDeadline;
        $entity->todayTimeDeadline1 = $todayTimeDeadline1;
        $entity->todayTimeDeadline2 = $todayTimeDeadline2;

        return $entity;
    }


    /**
     * リードタイムアドレス情報テーブル保存用のEntityを作成する
     *
     * @param Model $model
     * @return DefaultLeadtimeEntity
     */
    public function makeDepoAddressCsv(
        $depoCd,
        $jiscode,
        $zipCd,
        $prefCd,
        $siku,
        $tyou
    ): DefaultLeadtimeEntity {

        $entity = new DefaultLeadtimeEntity();
        $entity->depoCd = $depoCd;
        $entity->jiscode = $jiscode;
        $entity->zipCd = $zipCd;
        $entity->prefCd = $prefCd;
        $entity->siku = $siku;
        $entity->tyou = $tyou;

        return $entity;
    }
}
