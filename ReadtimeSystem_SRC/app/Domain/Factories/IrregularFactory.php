<?php
namespace App\Domain\Factories;

use App\Consts\AppConst;
use App\Domain\Entities\IrregularEntity;
use App\Domain\Models\Irregular;

class IrregularFactory
{

    /**
     * IrregularEntity作成
     *
     * @param Irregular $irregular
     * @return IrregularEntity
     */
    public function make(Irregular $irregular): IrregularEntity
    {
        $entity = new IrregularEntity();
        $entity->irregularId = $irregular->irregular_id;
        $entity->irregularType = $irregular->irregular_type;
        $entity->title = $irregular->title;
        $entity->cUse = $irregular->c_use;
        $entity->isValid = $irregular->is_valid;
        $entity->isBeforeDeadlineUndeliv = $irregular->is_before_deadline_undeliv;
        $entity->isTodayDeadlineUndeliv = $irregular->is_today_deadline_undeliv;
        $entity->isTimeSelectUndeliv = $irregular->is_time_select_undeliv;
        $entity->timeSelect = $irregular->time_select;
        $entity->isPersonalDelivery = $irregular->is_personal_delivery;
        $entity->deliveryDateType = $irregular->delivery_date_type;
        $entity->deliveryDate = $irregular->delivery_date;
        $entity->deliveryDateFrom = $irregular->delivery_date_from;
        $entity->deliveryDateTo = $irregular->delivery_date_to;
        $entity->orderDateType = $irregular->order_date_type;
        $entity->orderDate = $irregular->order_date;
        $entity->orderDateFrom = $irregular->order_date_from;
        $entity->orderDateTo = $irregular->order_date_to;
        $entity->isDepo = $irregular->is_depo;
        $entity->isItem = $irregular->is_item;
        $entity->isArea = $irregular->is_area;
        $entity->annoFrom = $irregular->anno_from;
        $entity->annoTo = $irregular->anno_to;
        $entity->annoAddr = $irregular->anno_addr;
        $entity->annoPeriod = $irregular->anno_period;
        $entity->annoTrans = $irregular->anno_trans;
        $entity->errorMessage = $irregular->error_message;
        $entity->transDepoCd = $irregular->trans_depo_cd;
        $entity->transDepoName = $irregular->deponame;
        $entity->remark = $irregular->remark;
        $entity->createdId = $irregular->created_id;
        $entity->createdAt = $irregular->created_at->format('y-m-d H:i:s');
        $entity->updatedId = $irregular->updated_id;
        $entity->updatedAt = $irregular->updated_at->format('y-m-d H:i:s');
        $entity->name1 = $irregular->name1;
        $entity->name2 = $irregular->name2;

        return $entity;

    }

    /**
     * イレギュラー設定画面用の初期化処理を行ったEntityを返却する
     *
     * @return IrregularEntity
     */
    public function makeInitialize(): IrregularEntity
    {
        $entity = new IrregularEntity();
        $entity->irregularType = AppConst::IRREGULAR_CLS_NO;
        $entity->isValid = true;
        $entity->isBeforeDeadlineUndeliv = false;
        $entity->isTodayDeadlineUndeliv = false;
        $entity->isTimeSelectUndeliv = false;
        $entity->isPersonalDelivery = false;
        $entity->isDepo = false;
        $entity->isItem = false;
        $entity->isArea = false;
        return $entity;
    }
}
