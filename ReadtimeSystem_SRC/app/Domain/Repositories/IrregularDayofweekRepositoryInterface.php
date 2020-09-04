<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\IrregularDayofweekEntity;

interface IrregularDayofweekRepositoryInterface
{
    /**
     * イレギュラー設定の取得
     *
     * @return array
     */
    public function findIrregularDayofweek(
        $irregularId
    ): array;
    /**
     * イレギュラー設定
     *
     * @return array
     */
    public function save(
        IrregularDayofweekEntity $entity
    );

    /**
     * イレギュラー曜日物理削除
     *
     * @param [type] $irregularId
     * @param integer|null $dateType
     * @return void
     */
    public function forceDeleteByIrregularId($irregularId, ?int $dateType = null);
}
