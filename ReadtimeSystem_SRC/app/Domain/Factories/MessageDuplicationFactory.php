<?php
namespace App\Domain\Factories;

use App\Consts\AppConst;
use App\Domain\Entities\MessageDuplicationEntity;
use App\Domain\Models\DepoCalAprInfo;
use App\Domain\Models\DepoCalInfo;
use App\Domain\Models\Irregular;
use stdClass;

class MessageDuplicationFactory extends BaseFactory
{

    /**
     * MessageDuplicationEntity作成
     *
     * @param Irregular $irregular
     * @return MessageDuplicationEntity
     */
    public function makeIrregularMessageDuplication(Irregular $irregular): MessageDuplicationEntity
    {
        $entity = new MessageDuplicationEntity();
        $entity->sort = $irregular->irregular_id;
        $entity->messageType = $irregular->message_type;
        $entity->irregularType = $irregular->irregular_type;
        $entity->irregularId = $irregular->irregular_id;
        $entity->annoAddr = $irregular->anno_addr;
        $entity->annoPeriod = $irregular->anno_period;
        $entity->annoTrans = $irregular->anno_trans;
        $entity->errorMessage = $irregular->error_message;

        return $entity;
    }

    /**
     * メッセージ重複確認（デポ休業等申請用）Entity作成
     *
     * @param DepoCalAprInfo $depoCalAprInfo
     * @return MessageDuplicationEntity
     */
    public function makeDepoCalInfoMessageDuplication(DepoCalAprInfo $depoCalAprInfo): MessageDuplicationEntity
    {
        $entity = new MessageDuplicationEntity();
        $entity->messageType = $depoCalAprInfo->message_type;
        $entity->sort = $depoCalAprInfo->depo_cal_id;
        $entity->depoCalId = $depoCalAprInfo->depo_cal_id;
        $entity->depoCd = $depoCalAprInfo->depo_cd;
        $entity->dateYm = $depoCalAprInfo->date_ym;
        $entity->deliveryDate = $depoCalAprInfo->delivery_date;
        $entity->annotationDisp = $depoCalAprInfo->annotation_disp;
        $entity->dayofweek = $depoCalAprInfo->dayofweek;
        $entity->publicHolidayStatus = $depoCalAprInfo->public_holiday_status;

        return $entity;
    }


    /**
     * メッセージ重複確認（デポ休業等申請画面パラメータ）Entity作成
     *
     * @param DepoCalAprInfo $depoCalAprInfo
     * @return MessageDuplicationEntity
     */
    public function makeDepoCalInfoFromParamMessageDuplication(stdClass $param): MessageDuplicationEntity
    {
        $entity = new MessageDuplicationEntity();
        $entity->messageType         = AppConst::MSG_TYPE_DEPO_REQ;
        $entity->sort                = 0;
        $entity->depoCalId           = null;
        $entity->depoCd              = property_exists($param, 'depoCd') ? $param->depoCd : '';
        $entity->dateYm              = property_exists($param, 'dateYm') ? $param->dateYm : '';
        $entity->deliveryDate        = property_exists($param, 'deliveryDate') ? $param->deliveryDate : '';
        $entity->annotationDisp      = property_exists($param, 'annotationDisp') ? $param->annotationDisp : '';
        $entity->dayofweek           = property_exists($param, 'dayofweek') ? $param->dayofweek : '';
        $entity->publicHolidayStatus = property_exists($param, 'publicHolidayStatus') ? $param->publicHolidayStatus : '';

        return $entity;
    }
}
