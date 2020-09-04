<?php
namespace App\Domain\Entities;

class IrregularListEntity extends BaseEntity
{
    // ビューのカラム数分の変数を用意
    private $irregular_id;
    private $title;
    private $depo_name;
    private $trans_depo_name;
    private $item_cd;
    private $deponame1;
    private $depo_cd;
    private $c_use_name;
    private $is_before_deadline_undeliv;
    private $is_today_deadline_undeliv;
    private $time_select;
    private $is_personal_delivery;
    private $is_area;
    private $delivery_date_type;
    private $delivery_date;
    private $delivery_date_from;
    private $delivery_date_to;
    private $order_date_type;
    private $order_date;
    private $order_date_from;
    private $order_date_to;
    private $updated_id;
    private $updated_at;
    public function __construct(
        $irregular_id = null,
        $title = null,
        $depo_name = null,
        $trans_depo_name = null,
        $item_cd = null,
        $deponame1 = null,
        $depo_cd = null,
        $c_use_name = null,
        $is_before_deadline_undeliv = null,
        $is_today_deadline_undeliv = null,
        $time_select = null,
        $is_personal_delivery = null,
        $is_area = null,
        $delivery_date_type = null,
        $delivery_date = null,
        $delivery_date_from = null,
        $delivery_date_to = null,
        $order_date_type = null,
        $order_date = null,
        $order_date_from = null,
        $order_date_to = null,
        $updated_id = null,
        $updated_at = null
    ) {
        $this->irregular_id = $irregular_id;
        $this->title = $title;
        $this->depo_name = $depo_name;
        $this->trans_depo_name = $trans_depo_name;
        $this->item_cd = $item_cd;
        $this->deponame1 = $deponame1;
        $this->depo_cd = $depo_cd;
        $this->c_use_name = $c_use_name;
        $this->is_before_deadline_undeliv = $is_before_deadline_undeliv;
        $this->is_today_deadline_undeliv = $is_today_deadline_undeliv;
        $this->time_select = $time_select;
        $this->is_personal_delivery = $is_personal_delivery;
        $this->is_area = $is_area;
        $this->delivery_date_type = $delivery_date_type;
        $this->delivery_date = $delivery_date;
        $this->delivery_date_from = $delivery_date_from;
        $this->delivery_date_to = $delivery_date_to;
        $this->order_date_type = $order_date_type;
        $this->order_date = $order_date;
        $this->order_date_from = $order_date_from;
        $this->order_date_to = $order_date_to;
        $this->updated_id = $updated_id;
        $this->updated_at = $updated_at;
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
