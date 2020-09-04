<?php
namespace App\Domain\Entities;

class DepoDefaultListEntity extends BaseEntity
{
    // ビューのカラム数分の変数を用意
    private $addrcd;
    private $jiscode;
    private $zipcode;
    private $pref;
    private $siku;
    private $tyou;
    private $deponame1;
    private $depo_cd;
    private $mon_today_delivery;
    private $depo_address_leadtime_tue_before_deadline_flg;
    private $tue_today_delivery;
    private $wed_before_deadline1;
    private $wed_before_deadline2;
    private $mon_before_deadline_flg;
    private $mon_today_delivery_flg;
    private $tue_before_deadline_flg;
    private $tue_today_delivery_flg;
    private $wed_before_deadline_flg;
    private $wed_today_delivery_flg;
    private $thu_before_deadline_flg;
    private $thu_today_delivery_flg;
    private $fri_before_deadline_flg;
    private $fri_today_delivery_flg;
    private $sat_before_deadline_flg;
    private $sat_today_delivery_flg;
    private $sun_before_deadline_flg;
    private $sun_today_delivery_flg;
    private $holi_before_deadline_flg;
    private $holi_before_today_delivery_flg;
    private $holi_deadline_flg;
    private $holi_today_delivery_flg;
    private $holi_after_deadline_flg;
    private $holi_after_today_delivery_flg;
    private $private_home_flg;
    private $congratulation_kbn_flg;
    private $transfer_post_depo_cd;
    private $deponame2;
    private $depo_lead_time;
    public function __construct(
        $addrcd = null,
        $jiscode = null,
        $zipcode = null,
        $pref = null,
        $siku = null,
        $tyou = null,
        $deponame1 = null,
        $depo_cd = null,
        $mon_today_delivery = null,
        $depo_address_leadtime_tue_before_deadline_flg = null,
        $tue_today_delivery = null,
        $wed_before_deadline1 = null,
        $wed_before_deadline2 = null,
        $mon_before_deadline_flg = null,
        $mon_today_delivery_flg = null,
        $tue_before_deadline_flg = null,
        $tue_today_delivery_flg = null,
        $wed_before_deadline_flg = null,
        $wed_today_delivery_flg = null,
        $thu_before_deadline_flg = null,
        $thu_today_delivery_flg = null,
        $fri_before_deadline_flg = null,
        $fri_today_delivery_flg = null,
        $sat_before_deadline_flg = null,
        $sat_today_delivery_flg = null,
        $sun_before_deadline_flg = null,
        $sun_today_delivery_flg = null,
        $holi_before_deadline_flg = null,
        $holi_before_today_delivery_flg = null,
        $holi_deadline_flg = null,
        $holi_today_delivery_flg = null,
        $holi_after_deadline_flg = null,
        $holi_after_today_delivery_flg = null,
        $private_home_flg = null,
        $congratulation_kbn_flg = null,
        $transfer_post_depo_cd = null,
        $deponame2 = null,
        $depo_lead_time = null
    ) {
        $this->addrcd = $addrcd;
        $this->jiscode = $jiscode;
        $this->zipcode = $zipcode;
        $this->pref = $pref;
        $this->siku = $siku;
        $this->tyou = $tyou;
        $this->deponame1 = $deponame1;
        $this->depo_cd = $depo_cd;
        $this->mon_today_delivery = $mon_today_delivery;
        $this->depo_address_leadtime_tue_before_deadline_flg = $depo_address_leadtime_tue_before_deadline_flg;
        $this->tue_today_delivery = $tue_today_delivery;
        $this->wed_before_deadline1 = $wed_before_deadline1;
        $this->wed_before_deadline2 = $wed_before_deadline2;
        $this->mon_before_deadline_flg = $mon_before_deadline_flg;
        $this->mon_today_delivery_flg = $mon_today_delivery_flg;
        $this->tue_before_deadline_flg = $tue_before_deadline_flg;
        $this->tue_today_delivery_flg = $tue_today_delivery_flg;
        $this->wed_before_deadline_flg = $wed_before_deadline_flg;
        $this->wed_today_delivery_flg = $wed_today_delivery_flg;
        $this->thu_before_deadline_flg = $thu_before_deadline_flg;
        $this->thu_today_delivery_flg = $thu_today_delivery_flg;
        $this->fri_before_deadline_flg = $fri_before_deadline_flg;
        $this->fri_today_delivery_flg = $fri_today_delivery_flg;
        $this->sat_before_deadline_flg = $sat_before_deadline_flg;
        $this->sat_today_delivery_flg = $sat_today_delivery_flg;
        $this->sun_before_deadline_flg = $sun_before_deadline_flg;
        $this->sun_today_delivery_flg = $sun_today_delivery_flg;
        $this->holi_before_deadline_flg = $holi_before_deadline_flg;
        $this->holi_before_today_delivery_flg = $holi_before_today_delivery_flg;
        $this->holi_deadline_flg = $holi_deadline_flg;
        $this->holi_today_delivery_flg = $holi_today_delivery_flg;
        $this->holi_after_deadline_flg = $holi_after_deadline_flg;
        $this->holi_after_today_delivery_flg = $holi_after_today_delivery_flg;
        $this->private_home_flg = $private_home_flg;
        $this->congratulation_kbn_flg = $congratulation_kbn_flg;
        $this->transfer_post_depo_cd = $transfer_post_depo_cd;
        $this->deponame2 = $deponame2;
        $this->depo_lead_time = $depo_lead_time;
    }

    /**
     * Getter.
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }
}
