<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\DepoCalInfoEntity;

interface DepoCalInfoRepositoryInterface
{

    /*
     * カレンダー情報削除
     *
     * @return integer
     */
    public function deleteDepoCalInfo(int $depocd, int $startDate);

    /**
     * カレンダー情報登録
     *
     * @return integer
     */
    public function inputDepoCalInfo($depoCalInputInfo);

    /**
     * カレンダー情報取得
     *
     * @return integer
     */
    public function getDepoCalInfo($searchParam);

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 【C_LI_02_リードタイムAPIサーバー】
     * 曜日祝日区分取得
     *
     * @param array $dates
     * @return array
     */
    public function getDepoCalInfoWeekHolidayType($dates);

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 【C_LI_02_リードタイムAPIサーバー】
     * 通常デポカレンダー引き当て情報取得
     *
     * @param array $cond
     * @param array $sysid front:C_LI_01, server:C_LI_02
     * @return array
     */
    public function getNormalDepoCalAllocationInfo($cond, $sysid = 'C_LI_01');

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 【C_LI_02_リードタイムAPIサーバー】
     * 通常デポ翌日カレンダー引き当て情報取得
     *
     * @param array $cond
     * @param array $sysid front:C_LI_01, server:C_LI_02
     * @return array
     */
    public function getNormalDepoNextCalAllocationInfo($cond, $sysid = 'C_LI_01');

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 【C_LI_02_リードタイムAPIサーバー】
     * サプライズデポカレンダー引き当て情報取得＿１
     *
     * @param array $cond
     * @param array $sysid front:C_LI_01, server:C_LI_02
     * @return array
     */
    public function getSpDepoNextCalAllocationInfo($cond, $sysid = 'C_LI_01');

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 【C_LI_02_リードタイムAPIサーバー】
     * サプライズデポカレンダー引き当て情報取得＿２
     *
     * @param array $cond
     * @return array
     */
    public function getSpDepoNextCalAllocationInfo2($cond);

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 【C_LI_02_リードタイムAPIサーバー】
     * エンタメデポカレンダー最短作業日取得
     *
     * @param array $cond
     * @param array $sysid front:C_LI_01, server:C_LI_02
     * @return array
     */
    public function getEtmDepoCalWorkDayInfo($cond, $sysid = 'C_LI_01');

    /**
     * デポカレンダー情報更新（承認）
     *
     * @param [type] $depoCd
     * @param [type] $deliveryDate
     * @param [type] $beforeDeadlineFlg
     * @param [type] $todayDeliveryFlg
     * @param [type] $beforeDeadlineLimitTime
     * @param [type] $todayDeadlineLimitTime
     * @param [type] $dayofweek
     * @param [type] $publicHolidayStatus
     * @param [type] $annotationDepo
     * @param [type] $annotationDisp
     * @return void
     */
    public function approvalDepoCalAprInfo($depoCd, $deliveryDate, $beforeDeadlineFlg, $todayDeliveryFlg, $beforeDeadlineLimitTime, $todayDeadlineLimitTime, $dayofweek, $publicHolidayStatus, $annotationDepo, $annotationDisp);

    /**
     * カレンダー情報承認データ反映
     *
     * @param DepoCalInfoEntity $depoCalInfoEntity
     * @return void
     */
    public function approvalUpdateDepoCalInfoApi(DepoCalInfoEntity $depoCalInfoEntity);

    /**
     * 【C_LB_01_リードタイムマスタチェックバッチ】
     * デポカレンダー情報不要データ削除
     *
     * @param array $unnecessaryDepoList
     * @return array
     */
    public function deleteDepoCalUnnecessary($unnecessaryDepoList);
}
