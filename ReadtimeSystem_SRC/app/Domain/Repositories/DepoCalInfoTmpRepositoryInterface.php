<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\DepoCalInfoTmpEntity;
use App\Domain\Models\DepoCalInfoTmp;

interface DepoCalInfoTmpRepositoryInterface
{

    /**
     * カレンダーTmp情報削除
     *
     * @param [type] $depocd
     * @param [type] $deliveryDate
     * @param integer $userId
     * @return void
     */
    public function deleteDepoCalInfoTmp($depocd, $deliveryDate,int $userId);

    /**
     * カレンダーTmp情報取得
     *
     * @return integer
     */
    public function getDepoCalInfoTmp($searchParam);

    /**
     * カレンダーTmp情報取得API
     *
     * @param integer $depoCd
     * @param string $deliveryDate
     * @param integer $userId
     * @return void
     */
    public function deleteDepoCalInfoTmpApr(int $depoCd,string $deliveryDate,int $userId);

    /**
     * カレンダーTmp情報取得API
     *
     * @param DepoCalInfoTmpEntity $depoCalInfoTmpEntity
     * @return void
     */
    public function saveDepoCalInfoTmpApr(DepoCalInfoTmpEntity $depoCalInfoTmpEntity);

    /**
     * カレンダーTmp情報承認処理
     *
     * @param integer $depoCd
     * @param string $deliveryDate
     * @return void
     */
    public function updateDepoCalInfoTmpApi(int $depoCd,string $deliveryDate);

    /**
     * 対象デポのカレンダー情報tmpを取得する
     *
     * @param string $dateYm
     * @param integer $depoCd
     * @return void
     */
    public function findTargetYmDepoCalInfoTmp(string $dateYm, int $depoCd): array;

    /**
     * 対象デポのカレンダー情報tmpを承認する
     *
     * @param array $idList
     * @return void
     */
    public function updateDepoCalInfoTmpForIdList(array $idList);

    /**
     * 対象デポのカレンダー情報tmpを取得する
     *
     * @param string $dateYm
     * @param integer $depoCd
     * @return void
     */
    public function findTargetYmDepoCalAprInfoTmp(string $dateYm, int $depoCd): array;

    /**
     * カレンダーTmp情報削除
     *
     * @return integer
     */
    public function deleteDepoCalAprInfoTmp($depocd, $deliveryDate);

    /**
     * 対象デポのカレンダー情報tmpを承認する
     *
     * @param array $idList
     * @return void
     */
    public function updateDepoCalAprInfoTmpForIdList(array $idList);

    /**
     * 不要デポのカレンダー情報tmpを削除する
     *
     * @param array $unnecessaryDepoList
     * @return void
     */
    public function deleteDepoCalTmpUnnecessary(array $unnecessaryDepoList);

    /**
     * 【C_LB_03】CleanUPバッチ
     * デポカレンダ－情報-tmp論理削除
     * @return void
     */
    public function deleteDepoCalInfoTmpCleanUp($criterionDate, $userId);
}
