<?php
namespace App\Domain\Factories;

use App\Domain\Entities\IrregularListEntity;
use App\Domain\Models\Irregular;

class IrregularListFactory
{
    /**
     * イレギュラー一覧Entity作成
     *
     * @param Irregular $irregular
     * @return IrregularListEntity
     */
    public function makeIrregularList(Irregular $irregular): IrregularListEntity
    {
        return new IrregularListEntity(
            $irregular->irregular_id,
            $irregular->title,
            $irregular->depo_name,
            $irregular->trans_depo_name,
            $irregular->item_cd,
            $irregular->deponame1,
            $irregular->depo_cd,
            $irregular->c_use_name,
            $irregular->is_before_deadline_undeliv,
            $irregular->is_today_deadline_undeliv,
            $irregular->time_select,
            $irregular->is_personal_delivery,
            $irregular->is_area,
            $irregular->delivery_date_type,
            $irregular->delivery_date,
            $irregular->delivery_date_from,
            $irregular->delivery_date_to,
            $irregular->order_date_type,
            $irregular->order_date,
            $irregular->order_date_from,
            $irregular->order_date_to,
            $irregular->updated_id,
            $irregular->updated_at
        );
    }
}
