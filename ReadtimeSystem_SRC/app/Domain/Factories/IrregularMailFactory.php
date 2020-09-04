<?php
namespace App\Domain\Factories;

use App\Application\Utilities\AppUtility;
use App\Domain\Entities\IrregularEntity;
use App\Domain\Entities\IrregularMailEntity;
use App\Domain\Models\Irregular;
use App\Domain\Models\IrregularArea;
use App\Domain\Models\IrregularDayofweek;
use App\Domain\Models\IrregularDepo;
use App\Domain\Models\IrregularItem;

class IrregularMailFactory
{

    /**
     * メール送信用のEntityを生成する
     *
     * @param Irregular $irregular
     * @param IrregularDepo $irregularDepo
     * @param IrregularItem $irregularItem
     * @param IrregularArea $irregularArea
     * @param IrregularDayofweek $irregularDayofweek
     * @return IrregularMailEntity
     */
    public function mackMailEntity(
        IrregularEntity $irregular,
        $irregularDepoList,
        $irregularItemList,
        $irregularAreaList,
        $irregularDayofweekList,
        $irregularTransDeponame
    ): IrregularMailEntity {
        // Collection
        $irregularDayofweek = collect($irregularDayofweekList);

        // 日付フォーマット
        $fmt = 'Y/m/d';
        // イレギュラー曜日情報テーブルのリスト - 日付区分 1
        $irregularOrderDayofweekList = $irregularDayofweek->filter(function ($dayofWeek) {
            return $dayofWeek->dateType == 1;
        })->all();
        // イレギュラー曜日情報テーブルのリスト - 日付区分 2
        $irregularDeliveryDayofweekList = $irregularDayofweek->filter(function ($dayofWeek) {
            return $dayofWeek->dateType == 2;
        })->all();

        return new IrregularMailEntity(
            $irregular->irregularId,
            $irregular->title,
            $irregular->irregularType,
            $irregular->cUse,
            $irregular->isValid,
            $irregular->isBeforeDeadlineUndeliv,
            $irregular->isTodayDeadlineUndeliv,
            $irregular->isTimeSelectUndeliv,
            $irregular->timeSelect,
            $irregular->isPersonalDelivery,
            $irregular->orderDateType,
            // AppUtility::getDateString($irregular->orderDate,$fmt),
            // AppUtility::getDateString($irregular->orderDateFrom,$fmt),
            // AppUtility::getDateString($irregular->orderDateTo,$fmt),
            null,
            null,
            null,
            $irregularOrderDayofweekList,
            $irregular->deliveryDateType,
            // AppUtility::getDateString($irregular->deliveryDate,$fmt),
            // AppUtility::getDateString($irregular->deliveryDateFrom,$fmt),
            // AppUtility::getDateString($irregular->deliveryDateTo,$fmt),
            null,
            null,
            null,
            $irregularDeliveryDayofweekList,
            $irregularDepoList,
            $irregularItemList,
            $irregularAreaList,
            $irregular->transDepoCd,
            $irregularTransDeponame,
            $irregular->annoAddr,
            $irregular->annoPeriod,
            $irregular->annoTrans,
            $irregular->errorMessage,
            $irregular->createdAt,
            $irregular->createdId,
            null,
            null,
        );
    }
}
