<?php

namespace App\Application\UseCases;

use App\Domain\Entities\DepoDefaultEntity;
use App\Domain\Repositories\DepoDefaultRepositoryInterface;

class DepoDefaultUseCase
{
    // デポカレンダーデフォルト情報
    private $iDepoDefaultRepository;

    /**
     * コンストラクタ
     *
     * @param DepoDefaultRepositoryInterface $iDepoDefaultRepository
     */
    public function __construct(
        DepoDefaultRepositoryInterface $iDepoDefaultRepository
    ) {
        $this->iDepoDefaultRepository = $iDepoDefaultRepository;
    }

    /**
     * デポカレンダー情報を取得する
     *
     * @return void
     */
    public function findDepoDefault(?int $depocd)
    {
        $depoDefaultModel = null;
        if ($depocd != null) {
            $depoDefaultModel = $this->iDepoDefaultRepository->findDepoDefault($depocd);
        }
        return $depoDefaultModel;
    }


    /**
     * デポカレンダー情報を登録する
     *
     * @return void
     */
    public function saveDepoDefault($depoDefaultParam)
    {
        // パラメータの加工
        $depoDefaultEntity = new DepoDefaultEntity(
            null,
            $depoDefaultParam['depoCd'],
            $depoDefaultParam['monBeforeDeadlineFlg'],
            $depoDefaultParam['monTodayDeliveryFlg'],
            $depoDefaultParam['tueBeforeDeadlineFlg'],
            $depoDefaultParam['tueTodayDeliveryFlg'],
            $depoDefaultParam['wedBeforeDeadlineFlg'],
            $depoDefaultParam['wedTodayDeliveryFlg'],
            $depoDefaultParam['thuBeforeDeadlineFlg'],
            $depoDefaultParam['thuTodayDeliveryFlg'],
            $depoDefaultParam['friBeforeDeadlineFlg'],
            $depoDefaultParam['friTodayDeliveryFlg'],
            $depoDefaultParam['satBeforeDeadlineFlg'],
            $depoDefaultParam['satTodayDeliveryFlg'],
            $depoDefaultParam['sunBeforeDeadlineFlg'],
            $depoDefaultParam['sunTodayDeliveryFlg'],
            $depoDefaultParam['holiBeforeDeadlineFlg'],
            $depoDefaultParam['holiBeforeTodayDeliveryFlg'],
            $depoDefaultParam['holiDeadlineFlg'],
            $depoDefaultParam['holiTodayDeliveryFlg'],
            $depoDefaultParam['holiAfterDeadlineFlg'],
            $depoDefaultParam['holiAfterTodayDeliveryFlg'],
            $depoDefaultParam['privateHomeFlg'],
            $depoDefaultParam['handingFlg'],
            $depoDefaultParam['congratulationKbnFlg'],
            $depoDefaultParam['transferPostDepoCd'],
            "",
            $depoDefaultParam['depoLeadTime'],
        );

        // デポカレンダーデフォルト情報登録処理
        $depoDefaultModel = $this->iDepoDefaultRepository->saveDepoDefault($depoDefaultEntity);
        return $depoDefaultModel;
    }

    /**
     * 不要デポ情報を取得する
     *
     * @return void
     */
    public function getUnnecessaryDepo()
    {
        $unnecessaryDepo = $this->iDepoDefaultRepository->getUnnecessaryDepo();

        return $unnecessaryDepo;
    }

    /**
     * デポカレンダーデフォルト情報不要データを削除する
     *
     * @param array $unnecessaryDepoList
     * @return void
     */
    public function deleteDepoDefaultUnnecessary($unnecessaryDepoList)
    {
        $result = $this->iDepoDefaultRepository->deleteDepoDefaultUnnecessary($unnecessaryDepoList);

        return $result;
    }
}
