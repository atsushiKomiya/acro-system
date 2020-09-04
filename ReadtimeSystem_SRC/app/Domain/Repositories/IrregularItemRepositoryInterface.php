<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\IrregularItemEntity;

interface IrregularItemRepositoryInterface
{
    /**
     * イレギュラー設定の取得
     *
     * @return array
     */
    public function findIrregularItem(
        $irregularId
    ): array;
    /**
     * イレギュラー設定
     *
     * @return array
     */
    public function save(
        IrregularItemEntity $entity
    );

    /**
     * イレギュラー商品削除（PK）
     *
     * @param integer $irregularItemId
     * @param integer $loginCd
     * @return void
     */
    public function deleteById(
        int $irregularItemId,
        int $loginCd
    );

    /**
     * イレギュラー商品削除（IrregularId）
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
