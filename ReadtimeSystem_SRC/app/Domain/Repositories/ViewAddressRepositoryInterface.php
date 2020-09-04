<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\ViewAddressEntity;
use Illuminate\Support\LazyCollection;

interface ViewAddressRepositoryInterface
{

    /**
     * 都道府県一覧の取得
     *
     * @return array
     */
    public function findPrefList(): array;

    /**
     * 都道府県の取得
     *
     * @return ViewAddressEntity
     */
    public function findPref($pref): ViewAddressEntity;

    /**
     * 住所一覧の取得
     *
     * @return array
     */
    public function findAddressList($selectCity): array;
    
    /**
     * 市区郡一覧の取得
     *
     * @return array
     */
    public function findCityList(): array;


    /**
     * 都道府県住所一覧の取得
     *
     * @return LazyCollection
     */
    public function findPrefAddressList($pref): LazyCollection;
    

    /**
     * 住所を一意に特定する
     *
     * @param [type] $prefCd
     * @param [type] $siku
     * @param [type] $tyou
     * @return ViewAddressEntity
     */
    public function findAddress($prefCd,$siku,$tyou): ?ViewAddressEntity;

    /**
     * デフォルト一覧の取得
     *
     * @param [type] $prefCd
     * @param [type] $depoCd
     * @param [type] $itemCategoryLargecd
     * @param [type] $itemCategoryMediumcd
     * @param [type] $itemCd
     * @param [type] $isConfig
     * @return LazyCollection
     */
    public function findDepoDefaultList($prefCd, $depoCd, $itemCategoryLargecd, $itemCategoryMediumcd ,$itemCd, $isConfig): LazyCollection;
}
