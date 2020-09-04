<?php

namespace App\Application\UseCases;

use App\Application\Utilities\StringUtility;
use App\Domain\Factories\DepoCalInfoTmpFactory;
use App\Domain\Repositories\DepoCalInfoTmpRepositoryInterface;

class DepoCalInfoTmpUseCase
{
    // 住所情報View
    private $iLeadtimeDisplayGroupRepository;
    // デポカレンダー情報-TMP
    private $iDepoCalInfoTmpRepository;

    /**
     * コンストラクタ
     *
     * @param DepoCalInfoTmpRepositoryInterface $iDepoCalInfoTmpRepository
     */
    public function __construct(
        DepoCalInfoTmpRepositoryInterface $iDepoCalInfoTmpRepository
    ) {
        $this->iDepoCalInfoTmpRepository = $iDepoCalInfoTmpRepository;
    }

     /**
      * カレンダー情報tmp削除
      *
      * @param [type] $depocd
      * @param [type] $startDate
      * @param integer $batchUserId
      * @return void
      */
    public function deleteDepoCalInfoTmp($depocd, $startDate,int $batchUserId)
    {
        $depo = $this->iDepoCalInfoTmpRepository->deleteDepoCalInfoTmp($depocd, $startDate, $batchUserId);

        return $depo;
    }

    /**
     * カレンダーTmp情報取得
     *
     * @return integer
     */
    public function getDepoCalInfoTmp($searchParam)
    {
        $data = $this->iDepoCalInfoTmpRepository->getDepoCalInfoTmp($searchParam);

        return $data;
    }

    /**
     * カレンダーTmp情報論理削除
     *
     * @param integer $depoCd
     * @param array $calendarList
     * @param integer $userId
     * @return void
     */
    public function deleteDepoCalInfoTmpApr(int $depoCd, array $calendarList, int $userId)
    {
        foreach($calendarList as $depoCalInfoTmp) {
            $deliveryDate = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'deliveryDate');
            if(!is_null($deliveryDate))
            {
                $this->iDepoCalInfoTmpRepository->deleteDepoCalInfoTmpApr($depoCd, $deliveryDate, $userId);
            }
        }

        return true;
    }

    /**
     * カレンダーTmp情報登録
     *
     * @param integer $depoCd
     * @param array $calendarList
     * @return void
     */
    public function saveDepoCalInfoTmpApr(int $depoCd, array $calendarList)
    {
        foreach($calendarList as $depoCalInfoTmp) {
            $factory = new DepoCalInfoTmpFactory();
            $entity = $factory->makeApplicationEntity($depoCd, $depoCalInfoTmp);
            $this->iDepoCalInfoTmpRepository->saveDepoCalInfoTmpApr($entity);
        }

        return true;
    }

    /**
     * カレンダーTmp情報承認処理
     *
     * @param integer $depoCd
     * @param array $calendarList
     * @return void
     */
    public function updateDepoCalInfoTmpApi(int $depoCd,array $calendarList)
    {
        foreach($calendarList as $depoCalInfoTmp) {
            $deliveryDate = StringUtility::getFromArrayIssetItem($depoCalInfoTmp, 'deliveryDate');
            if(!is_null($deliveryDate))
            {
                $this->iDepoCalInfoTmpRepository->updateDepoCalInfoTmpApi($depoCd, $deliveryDate);
            }
        }

        return true;
    }

    /*
     * デポカレンダー情報‐tmp不要データ論理削除
     *
     * @return integer
     */
    public function deleteDepoCalTmpUnnecessary($unnecessaryDepoInfo)
    {
        $depo = $this->iDepoCalInfoTmpRepository->deleteDepoCalTmpUnnecessary($unnecessaryDepoInfo);

        return $depo;
    }

    /**
     * 【C_LB_03】CreanUPバッチ
     * デポカレンダ－情報-tmp論理削除
     * @return void
     */
    public function deleteDepoCalInfoTmpCreanUp($criterionDate, $userId)
    {
        $data = $this->iDepoCalInfoTmpRepository->deleteDepoCalInfoTmpCreanUp($criterionDate, $userId);

        return $data;
    }
}
