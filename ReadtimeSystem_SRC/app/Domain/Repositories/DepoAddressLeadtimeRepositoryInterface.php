<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\DefaultLeadtimeEntity;
use Illuminate\Support\LazyCollection;

interface DepoAddressLeadtimeRepositoryInterface
{
    /**
     * デポ紐付き都道府県リスト取得
     *
     * @param integer $depoCd
     * @return LazyCollection
     */
    public function findDepoPrefCollection(int $depoCd): LazyCollection;

    /**
     * リードタイム情報の取得
     *
     * @return array
     */
    public function findLeadtimeAddressList(int $depocd, ?int $pref): array;

    /**
     * 削除済みのリードタイム情報も含めて取得する
     *
     * @param integer $depocd
     * @param integer $pref
     * @return array
     */
    public function findDepoLeadtimeAddressDeletedAtAllList(int $depocd, ?int $pref): array;

    /**
     * リードタイム情報の取得（CSV）
     *
     * @return array
     */
    public function findLeadtimeAddressListCsv(int $depocd, ?int $pref);

    /**
     * デポ住所紐付け用のリードタイムアドレス一覧を取得する
     *
     * @return array
     */
    public function findDepoAddressListCursor(int $depocd, ?int $pref): LazyCollection;

    /**
     * リードタイム情報の登録
     *
     * @return void
     */
    public function upsert(DefaultLeadtimeEntity $entity);

    /**
     * 住所紐付けCSVアップロード時のリードタイム情報の登録
     *
     * @param DefaultLeadtimeEntity $entity
     * @return void
     */
    public function addressCsvUploadSave(DefaultLeadtimeEntity $entity);

    /**
     * デポ住所コード紐付け画面からの登録
     *
     * @param DefaultLeadtimeEntity $entity
     * @return boolean
     */
    public function create(DefaultLeadtimeEntity $entity): bool;

    /**
     * リードタイム情報の更新
     *
     * @param DefaultLeadtimeEntity $entity
     * @return boolean
     */
    public function save(DefaultLeadtimeEntity $entity): bool;

    /**
     * デポ住所コード紐付け画面からの復元
     *
     * @param integer $depoAddressLeadtimeId
     * @return boolean
     */
    public function restore(int $depoAddressLeadtimeId): bool;

    /**
     * デポ住所コード紐付け画面からの削除
     *
     * @param integer $depoAddressLeadtimeId
     * @return boolean
     */
    public function delete(int $depoAddressLeadtimeId): bool;

    /**
     * デポ住所リードタイム情報不要データ削除
     *
     * @param array $unnecessaryDepoList
     */
    public function deleteDepoAddressUnnecessary($unnecessaryDepoList);

    /**
     * 住所を取り扱っているデポの一覧を取得する
     *
     * @param array $addressList
     * @return array
     */
    public function findSimilarAddressDepo(array $addressList): array;
    
}
