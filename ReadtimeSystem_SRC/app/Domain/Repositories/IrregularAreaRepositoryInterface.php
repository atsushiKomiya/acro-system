<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\IrregularAreaEntity;

interface IrregularAreaRepositoryInterface
{
    /**
     * イレギュラー設定の取得
     *
     * @return array
     */
    public function findIrregularArea(
        $irregularId
    ): array;
    /**
     * イレギュラー設定
     *
     * @return array
     */
    public function save(
        IrregularAreaEntity $entity
    );

    /**
     * イレギュラーエリア削除（PK）
     *
     * @param integer $irregularAreaId
     * @param integer $loginCd
     * @return void
     */
    public function deleteById(
        int $irregularAreaId,
        int $loginCd
    );

    /**
     * イレギュラーエリア削除（irregularId）
     *
     * @param integer $irregularId
     * @param integer $loginCd
     * @return void
     */
    public function deleteByIrregularId(
        int $irregularId,
        int $loginCd
    );
}
