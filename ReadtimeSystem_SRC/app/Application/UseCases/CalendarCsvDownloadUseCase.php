<?php

namespace App\Application\UseCases;

use App\Application\Utilities\AppUtility;
use App\Domain\Repositories\DepoCalAprInfoRepositoryInterface;

class CalendarCsvDownloadUseCase extends BaseCsvExportUseCase
{

    // デポカレンダー承認情報
    private $iDepoCalAprInfoRepository;

    /**
     * コンストラクタ
     *
     * @param DepoCalAprInfoRepositoryInterface $iDepoCalAprInfoRepository
     */
    public function __construct(
        DepoCalAprInfoRepositoryInterface $iDepoCalAprInfoRepository
    ) {
        $this->iDepoCalAprInfoRepository = $iDepoCalAprInfoRepository;
    }


    /**
     * デポ稼働日確認用のCSV作成処理
     *
     * @param string $ym
     * @param integer $pref
     * @param boolean $isNotApproval
     * @param boolean $isNotConfirm
     * @param integer $displayType
     * @return void
     */
    public function calendarCsv(string $ym, ?int $pref, bool $isNotApproval, bool $isNotConfirm, int $displayType)
    {
        // カーソル取得
        $ymdList = AppUtility::getTargetYmdList($ym);

        $model = $this->iDepoCalAprInfoRepository->findDepoCalendarListCsv($ym, $pref, $isNotApproval, $isNotConfirm, $displayType, $ymdList);

        // CSV作成
        $this->makeStreamCSV('calendar', $model, null, function ($cursor) {
            $result = $cursor;
            // 承認区分
            $result->approval_cls = is_null($result->approval_date) ? '未承認' : '承認済';
            // 承認者
            $result->approval_date = is_null($result->approval_date) ? '' : $result->approval_date;
            // 確認区分
            $result->confirm_flg = is_null($result->confirm_flg) ? '未確認' : '確認済';
            // 前日締切、当日配送
            for ($idx=1;$idx<32;$idx++) {
                // 前日
                $beforeFlg = $result['before_deadline_flg' . $idx];
                $beforeLimit = $result['before_deadline_limit_time' . $idx];
                $result['before_deadline_flg' . $idx] = AppUtility::getLimitTime($beforeFlg, $beforeLimit);
                // 当日
                $todayFlg = $result['today_delivery_flg' . $idx];
                $todayLimit = $result['today_deadline_limit_time' . $idx];
                $result['today_delivery_flg' . $idx] = AppUtility::getLimitTime($todayFlg, $todayLimit);
            }

            return $result;
        });
    }
}
