<?php
namespace App\Domain\Factories;

use App\Domain\Entities\IrregularDayofweekEntity;
use App\Domain\Models\IrregularDayofweek;

class IrregularDayofweekFactory
{

    /**
     * IrregularEntity作成
     *
     * @param Irregular $irregular
     * @return IrregularDayofweekEntity
     */
    public function make(IrregularDayofweek $irregularDayofweek): IrregularDayofweekEntity
    {
        $entity = new IrregularDayofweekEntity();
        $entity->irregularDayofweekId = $irregularDayofweek->irregular_dayofweek_id;
        $entity->irregularId = $irregularDayofweek->irregularId;
        $entity->dateType = $irregularDayofweek->date_type;
        $entity->dayofweek = $irregularDayofweek->dayofweek;
        $entity->publicHolidayStatus = $irregularDayofweek->public_holiday_status;

        return $entity;
    }
}
