<?php
namespace App\Domain\Factories;

use App\Domain\Entities\PublicHolidayEntity;
use App\Domain\Models\PublicHoliday;

class PublicHolidayFactory extends BaseFactory
{
    /**
     * PublicHolidayEntity作成
     *
     * @param PublicHoliday $publicHoliday
     * @return PublicHolidayEntity
     */
    public function make(PublicHoliday $publicHoliday): PublicHolidayEntity
    {
        return new PublicHolidayEntity(
            $publicHoliday->date,
            $publicHoliday->createdId,
            $publicHoliday->createdAt,
            $publicHoliday->updatedId,
            $publicHoliday->updatedAt,
            $publicHoliday->deletedId,
            $publicHoliday->deletedAt,
        );
    }
}
