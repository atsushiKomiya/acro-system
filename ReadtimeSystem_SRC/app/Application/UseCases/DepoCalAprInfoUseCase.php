<?php

namespace App\Application\UseCases;

use App\Application\Utilities\AppUtility;
use App\Domain\Entities\DepoCalAprInfoEntity;
use App\Domain\Entities\DepoChangeRequestCalendarEntity;
use App\Domain\Entities\ResultEntity;
use App\Domain\Repositories\DepoCalAprInfoRepositoryInterface;
use App\Domain\Repositories\DepoCalInfoRepositoryInterface;
use App\Domain\Repositories\DepoCalInfoTmpRepositoryInterface;
use Carbon\Carbon;

class DepoCalAprInfoUseCase
{
    // デポカレンダー承認情報
    private $iDepoCalAprInfoRepository;
    // デポカレンダー情報
    private $iDepoCalInfoRepository;
    // デポカレンダーTMP情報
    private $iDepoCalInfoTmpRepository;

    /**
     * コンストラクタ
     *
     * @param DepoCalAprInfoRepositoryInterface $iDepoCalAprInfoRepository
     * @param DepoCalInfoRepositoryInterface $iDepoCalInfoRepository
     * @param DepoCalInfoTmpRepositoryInterface $iDepoCalInfoTmpRepository
     */
    public function __construct(
        DepoCalAprInfoRepositoryInterface $iDepoCalAprInfoRepository,
        DepoCalInfoRepositoryInterface $iDepoCalInfoRepository,
        DepoCalInfoTmpRepositoryInterface $iDepoCalInfoTmpRepository
    ) {
        $this->iDepoCalAprInfoRepository = $iDepoCalAprInfoRepository;
        $this->iDepoCalInfoRepository = $iDepoCalInfoRepository;
        $this->iDepoCalInfoTmpRepository = $iDepoCalInfoTmpRepository;
    }

    /**
     * 最大日付デポ承認情報取得
     *
     * @param int $depocd
     * @return void
     */
    public function getMaxDate($depocd)
    {
        $depo = $this->iDepoCalAprInfoRepository->getMaxDate($depocd);

        return $depo;
    }

    /**
     * 表示グループの一覧を取得する
     *
     * @return integer
     */
    public function deleteDepoCalAprInfo($depocd, $startDate)
    {
        $depo = $this->iDepoCalAprInfoRepository->deleteDepoCalAprInfo($depocd, $startDate);

        return $depo;
    }

    /**
     * 有効デポ情報登録
     *
     * @return integer
     */
    public function inputDepoCalAprInfo($depoCalAprInfoArray)
    {
        $depo = $this->iDepoCalAprInfoRepository->inputDepoCalAprInfo($depoCalAprInfoArray);

        return $depo;
    }

    /**
     * デポ休業等申請情報を取得する
     *
     * @param int $depoCd
     * @param string $targetYm
     * @return DepoChangeRequestCalendarEntity
     */
    public function findChangeRequestCalendar(int $depoCd,string $targetYm): ?DepoChangeRequestCalendarEntity
    {
        $result = $this->iDepoCalAprInfoRepository->findChangeRequestCalendar($depoCd, $targetYm);
        return $result;
    }

    /**
     * 指定のデポの対象年月の承認情報を取得する
     *
     * @param integer $depoCd
     * @param string $dateYm
     * @return DepoCalAprInfoEntity
     */
    public function getDepoCalAprInfo(int $depoCd, string $dateYm): ?DepoCalAprInfoEntity
    {
        $depoCalAprInfo = $this->iDepoCalAprInfoRepository->getDepoCalAprInfo($depoCd, $dateYm);

        return $depoCalAprInfo;
    }

    /**
     * デポ稼働日確認リストを取得する
     *
     * @param string $ym
     * @param integer $pref
     * @param boolean $isNotApproval
     * @param boolean $isNotConfirm
     * @param integer $displayType
     * @return void
     */
    public function findDepoCalendarList(string $ym, ?int $pref, bool $isNotApproval, bool $isNotConfirm, int $displayType)
    {
        $ymdList = AppUtility::getTargetYmdList($ym);

        $result = $this->iDepoCalAprInfoRepository->findDepoCalendarList($ym, $pref, $isNotApproval, $isNotConfirm, $displayType, $ymdList);

        return $result;
    }

    /**
     * 承認処理
     *
     * @param string $ym
     * @param integer $depoCd
     * @param string $userId
     * @return ResultEntity
     */
    public function approval(string $ym, int $depoCd, string $userId): ResultEntity
    {
        $result = new ResultEntity();

        // 対象デポカレンダー情報tmp取得
        $depoCalAprInfoTmpList = $this->iDepoCalInfoTmpRepository->findTargetYmDepoCalAprInfoTmp($ym, $depoCd);

        if ($depoCalAprInfoTmpList) {
            // デポカレンダー情報tmp更新
            $idList = collect($depoCalAprInfoTmpList)->map(function ($tmp) {
                return $tmp->depo_cal_tmp_id;
            })->all();
            $this->iDepoCalInfoTmpRepository->updateDepoCalAprInfoTmpForIdList($idList);

            // デポカレンダー情報更新
            foreach ($depoCalAprInfoTmpList as $depoCalAprInfoTmp) {
                $this->iDepoCalInfoRepository->approvalDepoCalAprInfo(
                    $depoCalAprInfoTmp->depo_cd,
                    $depoCalAprInfoTmp->delivery_date,
                    $depoCalAprInfoTmp->before_deadline_flg,
                    $depoCalAprInfoTmp->today_delivery_flg,
                    $depoCalAprInfoTmp->before_deadline_limit_time,
                    $depoCalAprInfoTmp->today_deadline_limit_time,
                    $depoCalAprInfoTmp->dayofweek,
                    $depoCalAprInfoTmp->public_holiday_status,
                    $depoCalAprInfoTmp->annotation_depo,
                    $depoCalAprInfoTmp->annotation_disp,
                );
            }
        }

        // デポカレンダー承認情報更新
        $this->iDepoCalAprInfoRepository->approval($ym, $depoCd, $userId);

        // 成功
        $result->success();

        return $result;
    }

    /**
     * 旧デポカレンダー承認情報論理削除
     *
     * @param integer $depoCd
     * @param string $dateYm
     * @param integer $userId
     * @return void
     */
    public function deleteDepoCalAprInfoApi(int $depoCd, string $dateYm, int $userId)
    {
        $deleteResult = $this->iDepoCalAprInfoRepository->deleteDepoCalAprInfoApi($depoCd, $dateYm, $userId);

        return $deleteResult;
    }

    /**
     * デポカレンダー承認情報登録
     *
     * @param integer $depoCd
     * @param string $dateYm
     * @return void
     */
    public function saveDepoCalAprInfoApi(int $depoCd, string $dateYm)
    {
        $result = $this->iDepoCalAprInfoRepository->saveDepoCalAprInfoApi($depoCd, $dateYm);

        return $result;
    }

    /**
     * デポカレンダー承認処理
     *
     * @param integer $depoCd
     * @param string $dateYm
     * @param integer $loginId
     * @return void
     */
    public function approvalDepoCalAprInfoApi(int $depoCd,string $dateYm,int $loginId)
    {
        $result = $this->iDepoCalAprInfoRepository->approval($dateYm,$depoCd,$loginId);

        return $result;
    }

    /**
     * デポカレンダー承認情報確認
     *
     * @param int $depoCd
     * @param string $dateYm
     * @return void
     */
    public function confirmDepoCalAprInfoApi(int $depoCd, string $dateYm)
    {
        $result = $this->iDepoCalAprInfoRepository->confirmDepoCalAprInfoApi($depoCd, $dateYm);

        return $result;
    }

    /**
     * 有効な対象年月一覧取得処理
     *
     * @return array
     */
    public function findMonthList($depoCd): array
    {
        // 対象年月一覧取得
        $monthList = $this->iDepoCalAprInfoRepository->findMonthList($depoCd);

        // yyyyMM -> yyyy-MMのリストに変換する
        $result = collect($monthList)->mapWithKeys(function ($item) {
            $date = Carbon::parse($item->dateYm . '01');
            return [$item->dateYm => $date->format('Y-m')];
        })->all();

        // 空の場合は現在年月を格納する
        if(count($result) == 0) {
            $currentDate = Carbon::now();
            $result[$currentDate->format('Ym')] = $currentDate->format('Y-m');
        }

        return $result;
    }

    /**
     * デポ承認情報不要データ論理削除
     *
     * @return integer
     */
    public function deleteDepoCalAprUnnecessary($unnecessaryDepoList)
    {
        $depo = $this->iDepoCalAprInfoRepository->deleteDepoCalAprUnnecessary($unnecessaryDepoList);

        return $depo;
    }

    /**
     * 【C_LB_03】CreanUPバッチ
     * デポカレンダ－承認情報論理削除
     * @return void
     */
    public function deleteDepoCalAprInfoCreanUp($criterionDate, $userId)
    {
        $data = $this->iDepoCalAprInfoRepository->deleteDepoCalAprInfoCreanUp($criterionDate, $userId);

        return $data;
    }

    /**
     * 申込画面表示注釈（表示）一覧取得
     *
     * @param [type] $depoCdList
     * @param [type] $dateFrom
     * @param [type] $dateTo
     * @param [type] $dayofweekList
     * @param [type] $publicHolidayStatusList
     * @return array
     */
    public function findAnnoDispMessageList($depoCdList, $dateFrom, $dateTo, $dayofweekList, $publicHolidayStatusList): array
    {
        $resultList = [];
        $resultList = $this->iDepoCalAprInfoRepository->findAnnoDispMessageList($depoCdList, $dateFrom, $dateTo, $dayofweekList, $publicHolidayStatusList);

        return $resultList;
    }
}
