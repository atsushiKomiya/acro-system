<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\ViewAddressRepositoryInterface;

class DepoDefaultListUseCase
{
    // デポカレンダーデフォルト情報
    private $ViewAddressRepository;

    /**
     * コンストラクタ
     *
     * @param ViewAddressRepositoryInterface $ViewAddressRepository
     */
    public function __construct(
        ViewAddressRepositoryInterface $ViewAddressRepository
    ) {
        $this->ViewAddressRepository = $ViewAddressRepository;
    }

    /**
     * @return void
     */
    public function findDepoDefaultList($prefCd, $depoCd, $itemCategoryLargecd, $itemCategoryMediumcd ,$itemCd, $isConfig)
    {
        $depoDefaultListModel = $this->ViewAddressRepository->findDepoDefaultList($prefCd, $depoCd, $itemCategoryLargecd, $itemCategoryMediumcd ,$itemCd, $isConfig);
        $result = [];
        foreach($depoDefaultListModel as $model) {
            $result[] = $model;
        }

        return $result;
    }
}
