<?php
namespace App\Domain\Factories;

use App\Domain\Entities\DepoDefaultEntity;
use App\Domain\Models\DepoDefault;

class DepoDefaultFactory
{

    /**
     * DepoDefaultEntity作成
     *
     * @param DepoDefault $depoDefault
     * @return void
     */
    public function makeDepoDefaultCalendar(?DepoDefault $depoDefault, int $depocd): DepoDefaultEntity
    {
        $result = new DepoDefaultEntity(null, $depocd);

        if (!is_null($depoDefault)) {
            $result = new DepoDefaultEntity(
                $depoDefault->depo_default_id,
                $depocd,
                $depoDefault->mon_before_deadline_flg,
                $depoDefault->mon_today_delivery_flg,
                $depoDefault->tue_before_deadline_flg,
                $depoDefault->tue_today_delivery_flg,
                $depoDefault->wed_before_deadline_flg,
                $depoDefault->wed_today_delivery_flg,
                $depoDefault->thu_before_deadline_flg,
                $depoDefault->thu_today_delivery_flg,
                $depoDefault->fri_before_deadline_flg,
                $depoDefault->fri_today_delivery_flg,
                $depoDefault->sat_before_deadline_flg,
                $depoDefault->sat_today_delivery_flg,
                $depoDefault->sun_before_deadline_flg,
                $depoDefault->sun_today_delivery_flg,
                $depoDefault->holi_before_deadline_flg,
                $depoDefault->holi_before_today_delivery_flg,
                $depoDefault->holi_deadline_flg,
                $depoDefault->holi_today_delivery_flg,
                $depoDefault->holi_after_deadline_flg,
                $depoDefault->holi_after_today_delivery_flg,
                $depoDefault->private_home_flg,
                $depoDefault->handing_flg,
                $depoDefault->congratulation_kbn_flg,
                $depoDefault->transfer_post_depo_cd,
                $depoDefault->view_trans_depo,
                $depoDefault->depo_lead_time,
            );
        }

        return $result;
    }

    /**
     * DepoDefaultEntity作成
     *
     * @return void
     */
    public function makeUnnecessaryDepoInfo($res): DepoDefaultEntity
    {
        if (!is_null($res)) {
            $result = new DepoDefaultEntity(
                $res->depo_cd,
            );
        }

        return $result;
    }
}
