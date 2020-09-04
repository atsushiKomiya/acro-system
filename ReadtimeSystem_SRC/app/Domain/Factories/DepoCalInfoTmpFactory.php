<?php
namespace App\Domain\Factories;

use App\Application\Utilities\StringUtility;
use App\Domain\Entities\DepoCalInfoTmpEntity;
use App\Domain\Models\DepoCalInfoTmp;

class DepoCalInfoTmpFactory extends BaseFactory
{
    /**
     * デポカレンダーTmp情報生成
     *
     * @param DepoCalInfoTmp $depoCalInfoTmp
     * @return DepoCalInfoTmpEntity
     */
    public function makeDepoCalInfoTmp(DepoCalInfoTmp $depoCalInfoTmp): DepoCalInfoTmpEntity
    {
        $entity = new DepoCalInfoTmpEntity();
        $entity->deliveryDate = $depoCalInfoTmp->delivery_date;
        $entity->beforeDeadlineFlg = $depoCalInfoTmp->before_deadline_flg;
        $entity->todayDeliveryFlg = $depoCalInfoTmp->today_delivery_flg;
        $entity->beforeDeadlineLimitTime = $depoCalInfoTmp->before_deadline_limit_time;
        $entity->todayDeadlineLimitTime = $depoCalInfoTmp->today_deadline_limit_time;
        $entity->dayofweek = $depoCalInfoTmp->dayofweek;
        $entity->publicHolidayStatus = $depoCalInfoTmp->public_holiday_status;
        $entity->annotationDepo = $depoCalInfoTmp->annotation_depo;
        $entity->annotationDisp = $depoCalInfoTmp->annotation_disp;
        return $entity;
    }

    /**
     * 申請時用のEntityを作成する
     *
     * @param integer $depoCd
     * @param array $depoCalInfoTmp
     * @return DepoCalInfoTmpEntity
     */
    public function makeApplicationEntity(int $depoCd, array $depoCalInfoTmp): DepoCalInfoTmpEntity
    {
        $entity = new DepoCalInfoTmpEntity();

        $entity->depoCalTmpId = null;
        $entity->depoCd = $depoCd;
        $entity->deliveryDate = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'deliveryDate');
        $entity->beforeDeadlineFlg = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'beforeDeadlineFlg');
        $entity->todayDeliveryFlg = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'todayDeliveryFlg');
        $entity->beforeDeadlineLimitTime = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'beforeDeadlineLimitTime');
        $entity->todayDeadlineLimitTime = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'todayDeadlineLimitTime');
        $entity->dayofweek = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'dayofweek');
        $entity->publicHolidayStatus = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'publicHolidayStatus');
        $entity->annotationDepo = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'annotationDepo');
        $entity->annotationDisp = null;
        $entity->approvalFlg = null;

        return $entity;
    }
}
