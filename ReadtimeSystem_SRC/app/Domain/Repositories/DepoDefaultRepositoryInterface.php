<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\DepoDefaultEntity;

interface DepoDefaultRepositoryInterface
{
    /**
     * デポカレンダー情報取得
     *
     * @param int $depocd
     * @return DepoDefaultEntity
     */
    public function findDepoDefault(int $depocd): DepoDefaultEntity;


    /**
     * デポカレンダー情報の登録/更新
     *
     * @param DepoDefaultEntity $depoDefaultEntity
     * @return DepoDefaultEntity
     */
    public function saveDepoDefault(DepoDefaultEntity $depoDefaultEntity): ?DepoDefaultEntity;

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * 住所・商品紐づきデポ情報取得
     *
     * @param array $cond
     * @return array
     */
    public function getAddressItemRelationInfo($cond);

    /**
     * 【C_LB_01_リードタイムマスタチェックバッチ】
     * 不要デポ情報を取得する
     *
     * @return array
     */
    public function getUnnecessaryDepo();

    /**
     * デポカレンダーデフォルト情報不要データを削除する
     *
     * @param array $unnecessaryDepoList
     * @return void
     */
    public function deleteDepoDefaultUnnecessary($unnecessaryDepoList);
}
