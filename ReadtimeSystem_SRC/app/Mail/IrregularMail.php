<?php

namespace App\Mail;

use App\Application\UseCases\IrregularUseCase;
use App\Domain\Entities\IrregularMailEntity;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class IrregularMail extends Mailable
{
    use Queueable, SerializesModels;
    // 新規
    const MODE_NEW = 1;
    // 更新
    const MODE_UPDATE = 2;

    // パラメータ
    public $mode;
    public $irregularMailEntity;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mode, IrregularMailEntity $irregularMailEntity)
    {
        // メール送信Entity
        $this->irregularMailEntity = $irregularMailEntity;
        // モード
        $this->mode = $mode;
    }

    /**
     * Build the message.
     *
     * @param IrregularUseCase $irregularUseCase
     * @return void
     */
    public function build(IrregularUseCase $irregularUseCase)
    {
        // FROM
        $from = Config::get('mail.sgw_mail_from');
        // TO
        $systemTo = Config::get('mail.sgw_mail_syste_to');
        $logiTo = Config::get('mail.sgw_mail_logi_to');
        $to = array($systemTo,$logiTo);
        // タイトル
        $modeStr = $this->mode == self::MODE_NEW ? '【登録】' : '【更新】';

        // ------- Body ---------
        // 配送時間
        $timeSelectList = Config::get('delivery.time_select_list');
        $pTime = $this->irregularMailEntity->timeSelect;
        $timeSelect = collect($timeSelectList)->filter(function ($time, $key) use ($pTime) {
            return $key == $pTime;
        })->map(function ($time, $key) {
            return $time;
        })->first();
        // 用途
        $cuseList = collect($irregularUseCase->findCUseList());
        // イレギュラー設定側でC_USEのUsecaseを作成してた場合にここで取得
        $cUseCd = $this->irregularMailEntity->cUse;
        $cUse = $cuseList->first(function ($entity) use ($cUseCd) {
            return $entity->cUse == $cUseCd;
        });
        $cUseName = $cUse ? $cUse->cUseName : '';
        // 受注日曜日
        $irregularOrderDayofweekListStr = collect($this->irregularMailEntity->irregularOrderDayofweekList)
        ->map(function ($item) {
            return is_null($item->dayofweek) ? $item->dayofweek : $item->publicHolidayStatus;
        })->implode(',');
        // お届け曜日
        $irregularDeliveryDayofweekListStr = collect($this->irregularMailEntity->irregularDeliveryDayofweekList)
        ->map(function ($item) {
            return is_null($item->dayofweek) ? $item->dayofweek : $item->publicHolidayStatus;
        })->implode(',');
        // デポ
        $irregularDepoListStr = collect($this->irregularMailEntity->irregularDepoList)
        ->map(function ($depo) {
            return '【' . $depo->depocd . '】 ' . $depo->deponame;
        })->implode(',');
        // 商品
        $irregularItemListStr = collect($this->irregularMailEntity->irregularItemList)
        ->map(function ($item) {
            $str = '';
            if ($item->itemCd) {
                $str = '【' . $item->itemCd . '】 ' . $item->itemName;
            } elseif ($item->itemCategoryMediumCd) {
                $str = '【' . $item->itemCategoryMediumCd . '】 ' . $item->itemCategoryMediumName;
            } elseif ($item->itemCategoryLargeCd) {
                $str = '【' . $item->itemCategoryLargeCd . '】 ' . $item->itemCategoryLargeName;
            }
            return $str;
        })->implode(',');
        // 地域
        $irregularAreaListStr = collect($this->irregularMailEntity->irregularAreaList)
        ->map(function ($address) {
            return '【' . $address->pref . '】 ' . $address->siku . ' ' . $address->tyou;
        })->implode(',');

        return $this->from($from)
        ->to($to)
        ->subject($modeStr . $this->irregularMailEntity->title)
        ->view('emails.irregular')
        ->with([
            'irregularId' => $this->irregularMailEntity->irregularId,
            'title' => $this->irregularMailEntity->title,
            'irregularType' => $this->irregularMailEntity->irregularType,
            'cUse' => $cUseName,
            'isValid' => $this->irregularMailEntity->isValid,
            'isBeforeDeadlineUndeliv' => $this->irregularMailEntity->isBeforeDeadlineUndeliv,
            'isTodayDeadlineUndeliv' => $this->irregularMailEntity->isTodayDeadlineUndeliv,
            'isTimeSelectUndeliv' => $this->irregularMailEntity->isTimeSelectUndeliv,
            'timeSelect' => $timeSelect,
            'isPersonalDelivery' => $this->irregularMailEntity->isPersonalDelivery,
            'orderDateType' => $this->irregularMailEntity->orderDateType,
            'orderDate' => $this->irregularMailEntity->orderDate,
            'orderDateFrom' => $this->irregularMailEntity->orderDateFrom,
            'orderDateTo' => $this->irregularMailEntity->orderDateTo,
            'irregularOrderDayofweekListStr' => $irregularOrderDayofweekListStr,
            'deliveryDateType' => $this->irregularMailEntity->deliveryDateType,
            'deliveryDate' => $this->irregularMailEntity->deliveryDate,
            'deliveryDateFrom' => $this->irregularMailEntity->deliveryDateFrom,
            'deliveryDateTo' => $this->irregularMailEntity->deliveryDateTo,
            'irregularDeliveryDayofweekListStr' => $irregularDeliveryDayofweekListStr,
            'irregularDepoListStr' => $irregularDepoListStr,
            'irregularItemListStr' => $irregularItemListStr,
            'irregularAreaListStr' => $irregularAreaListStr,
            'transDepoCd' => $this->irregularMailEntity->transDepoCd,
            'transDepoName' => $this->irregularMailEntity->transDepoName,
            'annoAddr' => $this->irregularMailEntity->annoAddr,
            'annoPeriod' => $this->irregularMailEntity->annoPeriod,
            'annoTrans' => $this->irregularMailEntity->annoTrans,
            'errorMessage' => $this->irregularMailEntity->errorMessage,
            'createdAt' => $this->irregularMailEntity->createdAt,
            'createdId' => $this->irregularMailEntity->createdId,
            'name1' => $this->irregularMailEntity->name1,
            'name2' => $this->irregularMailEntity->name2
        ]);
    }
}
