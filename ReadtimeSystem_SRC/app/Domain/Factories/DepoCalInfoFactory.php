<?php
namespace App\Domain\Factories;

use App\Application\Utilities\StringUtility;
use App\Domain\Entities\DepoCalInfoEntity;
use App\Domain\Models\DepoCalInfo;

class DepoCalInfoFactory extends BaseFactory
{
    /**
     * デポカレンダー情報作成
     *
     * @param DepoCalInfo $depoCalInfo
     * @return DepoCalInfoEntity
     */
    public function makeDepoCalInfo(DepoCalInfo $depoCalInfo): DepoCalInfoEntity
    {
        $entity = new DepoCalInfoEntity();
        $entity->deliveryDate = $depoCalInfo->delivery_date;
        $entity->beforeDeadlineFlg = $depoCalInfo->before_deadline_flg;
        $entity->todayDeliveryFlg = $depoCalInfo->today_delivery_flg;
        $entity->beforeDeadlineLimitTime = $depoCalInfo->before_deadline_limit_time;
        $entity->todayDeadlineLimitTime = $depoCalInfo->today_deadline_limit_time;
        $entity->dayofweek = $depoCalInfo->dayofweek;
        $entity->publicHolidayStatus = $depoCalInfo->public_holiday_status;
        $entity->annotationDepo = $depoCalInfo->annotation_depo;
        $entity->annotationDisp = $depoCalInfo->annotation_disp;

        return $entity;
    }

    /**
     * 承認処理用のカレンダー情報Entityを作成する
     *
     * @param integer $depoCd
     * @param array $depoCalInfoTmp
     * @return DepoCalInfoEntity
     */
    public function makeApprovalEntity(int $depoCd, array $depoCalInfoTmp): DepoCalInfoEntity
    {
        $entity = new DepoCalInfoEntity();
        $entity->depoCalId = null;
        $entity->depoCd = $depoCd;
        $entity->deliveryDate = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'deliveryDate');
        $entity->beforeDeadlineFlg = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'beforeDeadlineFlg');
        $entity->todayDeliveryFlg = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'todayDeliveryFlg');
        $entity->beforeDeadlineLimitTime = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'beforeDeadlineLimitTime');
        $entity->todayDeadlineLimitTime = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'todayDeadlineLimitTime');
        $entity->dayofweek = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'dayofweek');
        $entity->publicHolidayStatus = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'publicHolidayStatus');
        $entity->annotationDepo = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'annotationDepo');
        $entity->annotationDisp = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'annotationDisp');

        return $entity;
    }
}
