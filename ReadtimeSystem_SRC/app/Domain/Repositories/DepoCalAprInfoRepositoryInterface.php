<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\DepoCalAprInfoEntity;
use App\Domain\Entities\DepoChangeRequestCalendarEntity;
use Illuminate\Support\LazyCollection;

interface DepoCalAprInfoRepositoryInterface
{

    /**
     * 未承認カレンダー件数取得
     *
     * @return integer
     */
    public function findUnapprovedCount(): int;

    public function getMaxDate($depocd);

    public function deleteDepoCalAprInfo($depocd, $deliveryDate, $userId);

    public function inputDepoCalAprInfo($depoCalAprInfoArray);

    /**
     * 指定のデポの対象年月の承認情報を取得する
     *
     * @param integer $depoCd
     * @param string $dateYm
     * @return DepoCalAprInfoEntity
     */
    public function getDepoCalAprInfo(int $depoCd, string $dateYm): ?DepoCalAprInfoEntity;

    /**
     * デポ休業等申請情報取得
     *
     * @param integer $depoCd
     * @param string $targetYm
     * @return DepoChangeRequestCalendarEntity
     */
    public function findChangeRequestCalendar(int $depoCd, string $targetYm): ?DepoChangeRequestCalendarEntity;

    /**
     * デポカレンダー一覧取得
     *
     * @param string $ym
     * @param ?integer $pref
     * @param boolean $isNotApproval
     * @param boolean $isNotConfirm
     * @param integer $displayType
     * @param array $ymdList
     * @return array
     */
    public function findDepoCalendarList(string $ym, ?int $pref, bool $isNotApproval, bool $isNotConfirm, int $displayType, array $ymdList): array;

    /**
     * デポカレンダー一覧件数取得
     *
     * @param string $ym
     * @param ?integer $pref
     * @param boolean $isNotApproval
     * @param boolean $isNotConfirm
     * @param integer $displayType
     * @param array $ymdList
     * @return int
     */
    public function countDepoCalendarList(string $ym, ?int $pref, bool $isNotApproval, bool $isNotConfirm, int $displayType, array $ymdList): int;

    /**
     * デポカレンダー一覧CSV取得用
     *
     * @param string $ym
     * @param ?integer $pref
     * @param boolean $isNotApproval
     * @param boolean $isNotConfirm
     * @param integer $displayType
     * @param array $ymdList
     * @return LazyCollection
     */
    public function findDepoCalendarListCsv(string $ym, ?int $pref, bool $isNotApproval, bool $isNotConfirm, int $displayType, array $ymdList): LazyCollection;

    /**
     * デポカレンダー承認
     *
     * @param string $dateYm
     * @param integer $depoCd
     * @param string $userId
     * @return int
     */
    public function approval(string $dateYm, int $depoCd, string $userId): bool;

    /**
     * カレンダー承認情報削除
     *
     * @param integer $depoCd
     * @param string $dateYm
     * @param integer $userId
     * @return void
     */
    public function deleteDepoCalAprInfoApi(int $depoCd, string $dateYm, int $userId);

     /**
      * デポカレンダー承認情報登録
      *
      * @param integer $depoCd
      * @param string $dateYm
      * @return void
      */
    public function saveDepoCalAprInfoApi(int $depoCd, string $dateYm);

    /**
     * デポカレンダー承認情報確認処理
     *
     * @param integer $depoCd
     * @param string $dateYm
     * @return void
     */
    public function confirmDepoCalAprInfoApi(int $depoCd, string $dateYm);

    /**
     * 有効な対象年月一覧の取得
     *
     * @return array
     */
    public function findMonthList($depoCd): array;

    /**
     * デポ承認情報不要データ論理削除
     *
     * @param array $unnecessaryDepoList
     */
    public function deleteDepoCalAprUnnecessary($unnecessaryDepoList);

    /**
     * 【C_LB_03】CleanUPバッチ
     * デポカレンダ－承認情報論理削除
     * @return void
     */
    public function deleteDepoCalAprInfoCleanUp($criterionDate, $userId);

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
    public function findAnnoDispMessageList($depoCdList, $dateFrom, $dateTo, $dayofweekList, $publicHolidayStatusList): array;

}
