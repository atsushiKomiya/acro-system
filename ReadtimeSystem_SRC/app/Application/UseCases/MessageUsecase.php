<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\DepoCalInfoRepositoryInterface;
use App\Domain\Repositories\IrregularRepositoryInterface;
use App\Domain\Repositories\ItemCategoryLargeRepositoryInterface;
use App\Domain\Repositories\ItemCategoryMediumRepositoryInterface;
use App\Domain\Repositories\MessageDuplicationRepositoryInterface;
use App\Domain\Repositories\ViewAddressRepositoryInterface;
use App\Domain\Repositories\ViewDepoRepositoryInterface;
use App\Domain\Repositories\ViewItemRepositoryInterface;

class MessageUsecase
{
    // イレギュラー連携マスタ
    private $iIrregularRepository;
    private $iDepoCalInfoRepository;
    private $iViewDepoRepository;
    private $iItemCategoryLargeRepository;
    private $iItemCategoryMediumRepository;
    private $iViewItemRepository;
    private $iViewAddressRepository;

    /**
     * コンストラクタ
     *
     * @param MessageDuplicationRepositoryInterface $iMessageDuplicationRepository
     */
    public function __construct(
        IrregularRepositoryInterface $iIrregularRepository,
        DepoCalInfoRepositoryInterface $iDepoCalInfoRepository,
        ViewDepoRepositoryInterface $iViewDepoRepository,
        ItemCategoryLargeRepositoryInterface $iItemCategoryLargeRepository,
        ItemCategoryMediumRepositoryInterface $iItemCategoryMediumRepository,
        ViewItemRepositoryInterface $iViewItemRepository,
        ViewAddressRepositoryInterface $iViewAddressRepository
    ) {
        $this->iIrregularRepository = $iIrregularRepository;
        $this->iDepoCalInfoRepository = $iDepoCalInfoRepository;
        $this->iViewDepoRepository = $iViewDepoRepository;
        $this->iItemCategoryLargeRepository = $iItemCategoryLargeRepository;
        $this->iItemCategoryMediumRepository = $iItemCategoryMediumRepository;
        $this->iViewItemRepository = $iViewItemRepository;
        $this->iViewAddressRepository = $iViewAddressRepository;
    }

    /**
     * デポ名取得
     *
     * @return depoNames
     */
    public function findDepo($depoCds)
    {
        $depoNames = '';

        foreach ($depoCds as $depoCd) {
            $depo = $this->iViewDepoRepository->findViewDepo($depoCd);
            if ($depo) {
                $depoNames = $depoNames.'【'.$depoCd.'】'.$depo->deponame;
                if ($depoCd != end($depoCds)) {
                    $depoNames = $depoNames.',';
                }
            }
        }

        return $depoNames;
    }
    /**
     * 商品カテゴリ大名取得
     *
     * @return itemCategoryLargeNames
     */
    public function findItemCategoryLarge($itemCategoryLargeCds)
    {
        $itemCategoryLargeNames = '';

        foreach ($itemCategoryLargeCds as $itemCategoryLargeCd) {
            $itemCategoryLarge = $this->iItemCategoryLargeRepository->findItemCategoryLarge($itemCategoryLargeCd);
            if ($itemCategoryLarge) {
                $itemCategoryLargeNames = $itemCategoryLargeNames.'【'.$itemCategoryLargeCd.'】'.$itemCategoryLarge->itemCategoryLargeName;
                if ($itemCategoryLargeCd != end($itemCategoryLargeCds)) {
                    $itemCategoryLargeNames = $itemCategoryLargeNames.',';
                }
            }
        }
        
        return $itemCategoryLargeNames;
    }
    /**
     * 商品カテゴリ中名取得
     *
     * @return itemCategoryMediumNames
     */
    public function findItemCategoryMedium($itemCategoryMediumCds)
    {
        $itemCategoryMediumNames = '';

        foreach ($itemCategoryMediumCds as $itemCategoryMediumCd) {
            $itemCategoryMedium = $this->iItemCategoryMediumRepository->findItemCategoryMedium($itemCategoryMediumCd);
            if ($itemCategoryMedium) {
                $itemCategoryMediumNames = $itemCategoryMediumNames.'【'.$itemCategoryMediumCd.'】'.$itemCategoryMedium->itemCategoryMediumName;
                if ($itemCategoryMediumCd != end($itemCategoryMediumCds)) {
                    $itemCategoryMediumNames = $itemCategoryMediumNames.',';
                }
            }
        }

        return $itemCategoryMediumNames;
    }
    /**
     * 商品名取得
     *
     * @return itemNames
     */
    public function findViewItem($itemCds)
    {
        $itemNames = '';

        foreach ($itemCds as $itemCd) {
            $item = $this->iViewItemRepository->findViewItem($itemCd);
            if ($item) {
                $itemNames = $itemNames.'【'.$itemCd.'】'.$item->itemName;
                if ($itemCd != end($itemCds)) {
                    $itemNames = $itemNames.',';
                }
            }
        }

        return $itemNames;
    }

    /**
     * 都道府県名取得
     *
     * @return prefNames
     */
    public function findPref($prefs)
    {
        $prefNames = '';

        foreach ($prefs as $pref) {
            $address = $this->iViewAddressRepository->findPref($pref);
            if ($pref) {
                $prefNames = $prefNames.$address->prefName;
                if ($pref != end($prefs)) {
                    $prefNames = $prefNames.',';
                }
            }
        }

        return $prefNames;
    }
}
