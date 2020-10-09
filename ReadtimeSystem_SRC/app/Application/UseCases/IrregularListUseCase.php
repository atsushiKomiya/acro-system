<?php

namespace App\Application\UseCases;

// use App\Domain\Entities\DepoDefaultListEntity;

use App\Domain\Entities\IrregularListSearchEntity;
use App\Domain\Repositories\IrregularRepositoryInterface;

class IrregularListUseCase
{
    // デポカレンダーデフォルト情報
    private $iIrregularRepository;

    /**
     * コンストラクタ
     *
     * @param IrregularRepositoryInterface $iIrregularRepository
     */
    public function __construct(
        IrregularRepositoryInterface $iIrregularRepository
    ) {
        $this->iIrregularRepository = $iIrregularRepository;
    }

    /**
     * @return void
     */
    public function findIrregularList(IrregularListSearchEntity $searchCondition)
    {
        $irregularListModel = null;
        // 検索処理
        $irregularListModel = $this->iIrregularRepository->findIrregularList($searchCondition);

        return $irregularListModel;
    }

    /**
     * カンマ区切りのパラメータをSIMILAR TO句で使用するために変換する
     * @return void
     */
    public function similarToTransCondition($transCondition)
    {
        if (empty($transCondition)) {
            return null;
        }

        $returnTransCondition = '%('.str_replace(',', '|', $transCondition).')%';
        return $returnTransCondition;
    }

    /**
     * @return void
     */
    public function countIrregularList(IrregularListSearchEntity $condition)
    {
        $irregularListModel = null;
        // 件数取得処理
        $irregularListModel = $this->iIrregularRepository->countIrregularList($condition);

        return $irregularListModel;
    }
}
