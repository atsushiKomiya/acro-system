<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\ViewAddressRepositoryInterface;
use App\Domain\Repositories\ViewLeadtimeMessageRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

class AddressUseCase
{
    // 住所情報View
    private $iViewAddressRepository;

    /**
     * コンストラクタ
     *
     * @param ViewAddressRepositoryInterface $iViewAddressRepository
     * @param ViewLeadtimeMessageRepositoryInterface $iViewLeadtimeMessageRepository
     */
    public function __construct(
        ViewAddressRepositoryInterface $iViewAddressRepository
    ) {
        $this->iViewAddressRepository = $iViewAddressRepository;
    }

    /**
     * 都道府県一覧取得処理
     *
     * @return Collection
     */
    public function findPrefList(): Collection
    {
        // 都道府県一覧取得
        $prefList = $this->iViewAddressRepository->findPrefList();

        // key - valueに変換
        $prefCollect = collect($prefList)->sort()->mapWithKeys(function ($item) {
            return [$item->pref => $item];
        });

        return $prefCollect;
    }

    /**
     * 市区郡一覧取得処理
     *
     * @return Collection
     */
    public function findCityList(): Collection
    {

        // key - valueに変換
        $cityList = $this->iViewAddressRepository->findCityList();

        // key - valueに変換
        $cityCollect = collect($cityList)->sort()->mapWithKeys(function ($item) {
            return [$item->jiscode => $item];
        });

        return $cityCollect;
    }

    /**
     * 住所一覧取得処理
     *
     * @return Array
     */
    public function findAddressList($selectCity): array
    {

        // key - valueに変換
        $addressList = $this->iViewAddressRepository->findAddressList($selectCity);

        return $addressList;
    }

    /**
     * 都道府県住所一覧取得処理
     *
     * @return LazyCollection
     */
    public function findPrefAddressList($prefCd): LazyCollection
    {
        $addressList = $this->iViewAddressRepository->findPrefAddressList($prefCd);

        return $addressList;
    }
}
