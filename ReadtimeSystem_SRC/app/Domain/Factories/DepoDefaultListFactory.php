<?php
namespace App\Domain\Factories;

use App\Domain\Entities\DepoDefaultListEntity;
use App\Domain\Models\ViewAddress;

class DepoDefaultListFactory
{
    /**
     * デフォルトリストEntity作成
     *
     * @param ViewAddress $viewAddress
     * @return DepoDefaultListEntity
     */
    public function mafeDefaultList(ViewAddress $viewAddress): DepoDefaultListEntity
    {
        return new DepoDefaultListEntity(
            $viewAddress->addrcd,
            $viewAddress->jiscode,
            $viewAddress->zipcode,
            $viewAddress->pref,
            $viewAddress->siku,
            $viewAddress->tyou,
            $viewAddress->deponame1,
            $viewAddress->depo_cd,
            $viewAddress->mon_today_delivery,
            $viewAddress->depo_address_leadtime_tue_before_deadline_flg,
            $viewAddress->tue_today_delivery,
            $viewAddress->wed_before_deadline1,
            $viewAddress->wed_before_deadline2,
            $viewAddress->mon_before_deadline_flg,
            $viewAddress->mon_today_delivery_flg,
            $viewAddress->tue_before_deadline_flg,
            $viewAddress->tue_today_delivery_flg,
            $viewAddress->wed_before_deadline_flg,
            $viewAddress->wed_today_delivery_flg,
            $viewAddress->thu_before_deadline_flg,
            $viewAddress->thu_today_delivery_flg,
            $viewAddress->fri_before_deadline_flg,
            $viewAddress->fri_today_delivery_flg,
            $viewAddress->sat_before_deadline_flg,
            $viewAddress->sat_today_delivery_flg,
            $viewAddress->sun_before_deadline_flg,
            $viewAddress->sun_today_delivery_flg,
            $viewAddress->holi_before_deadline_flg,
            $viewAddress->holi_before_today_delivery_flg,
            $viewAddress->holi_deadline_flg,
            $viewAddress->holi_today_delivery_flg,
            $viewAddress->holi_after_deadline_flg,
            $viewAddress->holi_after_today_delivery_flg,
            $viewAddress->private_home_flg,
            $viewAddress->congratulation_kbn_flg,
            $viewAddress->transfer_post_depo_cd,
            $viewAddress->deponame2,
            $viewAddress->depo_lead_time
        );
    }

    
    /**
     * 都道府県Entity作成
     *
     * @param ViewAddress $viewAddress
     * @return DepoDefaultListEntity
     */
    public function makePref(ViewAddress $viewAddress): ViewAddressEntity
    {
        return new DepoDefaultListEntity(
            null,
            null,
            null,
            $viewAddress->pref,
            $viewAddress->pref_name,
            null,
            null
        );
    }

    /**
     * 市区郡Entity作成
     *
     * @param ViewAddress $viewAddress
     * @return depoDefaultListEntity
     */
    public function makeCity(ViewAddress $viewAddress): ViewAddressEntity
    {
        return new depoDefaultListEntity(
            null,
            $viewAddress->jiscode,
            null,
            $viewAddress->pref,
            $viewAddress->pref_name,
            $viewAddress->siku,
            null
        );
    }

    /**
     * 町村Entity作成
     *
     * @param ViewAddress $viewAddress
     * @return depoDefaultListEntity
     */
    public function makeAddress(ViewAddress $viewAddress): ViewAddressEntity
    {
        return new depoDefaultListEntity(
            $viewAddress->addrcd,
            $viewAddress->jiscode,
            $viewAddress->zipcode,
            $viewAddress->pref,
            $viewAddress->pref_name,
            $viewAddress->siku,
            $viewAddress->tyou
        );
    }
}
