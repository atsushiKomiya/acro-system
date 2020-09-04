<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\DepoItemInfoEntity;
use Illuminate\Support\LazyCollection;

interface DepoItemInfoRepositoryInterface
{
    /**
     * 削除済みも含めてデポ取扱商品情報の取得
     *
     * @param integer $depocd
     * @return array
     */
    public function findDepoItemInfoDeletedAtAllList(int $depocd): array;

    /**
     * デポ取扱商品情報の取得
     *
     * @param integer $depocd
     * @return array
     */
    public function findDepoItemInfoList(int $depocd): array;

    /**
     * デポ取扱商品情報の取得（CSV）
     *
     * @param integer $depocd
     * @return LazyCollection
     */
    public function findDepoItemInfoListCsv(int $depocd): LazyCollection;

    /**
     * デポ取扱商品情報の登録
     *
     * @param DepoItemInfoEntity $entity
     * @return boolean
     */
    public function save(DepoItemInfoEntity $entity): bool;

    /**
     * デポ取扱商品情報の削除
     *
     * @param integer $depoItemInfoId
     * @return boolean
     */
    public function delete(int $depoItemInfoId): bool;

    /**
     * デポ取扱商品情報の復元
     *
     * @param integer $depoItemInfoId
     * @return boolean
     */
    public function restore(int $depoItemInfoId): bool;

    /**
     * デポ取扱商品不要データ削除
     *
     * @param array $unnecessaryDepoList
     * @return array
     */
    public function deleteDepoItemUnnecessary($unnecessaryDepoList);

    /**
     * 商品を取り扱っているデポの一覧を取得する
     *
     * @param array $itemList
     * @return array
     */
    public function findSimilarItemDepo(array $itemList): array;

}
