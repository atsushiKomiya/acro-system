<?php
namespace App\Domain\Factories;

use App\Domain\Entities\TimeSelectEntity;
use App\Domain\Models\TimeSelect;

class TimeSelectFactory
{

    /**
     * 用途Entity作成
     *
     * @param TimeSelect $timeSelect
     * @return TimeSelectEntity
     */
    public function makeTimeSelect(TimeSelect $timeSelect): TimeSelectEntity
    {
        return new TimeSelectEntity(
            $timeSelect->undeliv_type,
            $timeSelect->undeliv_type_name
        );
    }
}
