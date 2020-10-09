<?php

namespace App\Application\UseCases;

use App\Application\Utilities\StringUtility;
use App\Domain\Factories\DepoCalInfoFactory;
use App\Domain\Repositories\LeadtimeDisplayGroupRepositoryInterface;
use App\Domain\Repositories\DepoCalInfoRepositoryInterface;
use Illuminate\Support\Collection;

class DepoCalInfoUseCase
{
    // デポカレンダー情報
    private $iDepoCalInfoRepository;

    /**
     * コンストラクタ
     *
     * @param LeadtimeDisplayGroupRepositoryInterface $iViewDepoRepository
     */
    public function __construct(
        LeadtimeDisplayGroupRepositoryInterface $iLeadtimeDisplayGroupRepository,
        DepoCalInfoRepositoryInterface $iDepoCalInfoRepository
    ) {
        $this->iLeadtimeDisplayGroupRepository = $iLeadtimeDisplayGroupRepository;
        $this->iDepoCalInfoRepository = $iDepoCalInfoRepository;
    }

    /*
     * カレンダー情報削除
     *
     * @param int $depocd
     * @return void
     */
    public function deleteDepoCalInfo(int $depocd, int $startDate)
    {
        $data = $this->iDepoCalInfoRepository->deleteDepoCalInfo($depocd, $startDate);

        return $data;
    }

    /**
     * カレンダー情報登録
     *
     * @return integer
     */
    public function inputDepoCalInfo($depoCalInputInfo)
    {
        $data = $this->iDepoCalInfoRepository->inputDepoCalInfo($depoCalInputInfo);

        return $data;
    }

    /**
     * カレンダー情報取得
     *
     * @return integer
     */
    public function getDepoCalInfo($searchParam)
    {
        $data = $this->iDepoCalInfoRepository->getDepoCalInfo($searchParam);

        return $data;
    }

    /**
     * カレンダー情報承認データ反映
     *
     * @param integer $depoCd
     * @param array $calendarList
     * @return void
     */
    public function approvalUpdateDepoCalInfoApi(int $depoCd,array $calendarList)
    {
        foreach($calendarList as $depoCalInfoTmp) {
            $factory = new DepoCalInfoFactory();
            $entity = $factory->makeApprovalEntity($depoCd, $depoCalInfoTmp);
            $this->iDepoCalInfoRepository->approvalUpdateDepoCalInfoApi($entity);
        }

        return true;
    }

    /*
     * デポカレンダー情報不要データ削除
     *
     * @return integer
     */
    public function deleteDepoCalUnnecessary($unnecessaryDepoList)
    {
        $data = $this->iDepoCalInfoRepository->deleteDepoCalUnnecessary($unnecessaryDepoList);

        return $data;
    }

    /**
     * 【C_LB_03】CleanUPバッチ
     * デポカレンダ－情報削除
     * @return void
     */
    public function deleteDepoCalInfoCleanUp($criterionDate)
    {
        $data = $this->iDepoCalInfoRepository->deleteDepoCalInfoCleanUp($criterionDate);

        return $data;
    }
}
