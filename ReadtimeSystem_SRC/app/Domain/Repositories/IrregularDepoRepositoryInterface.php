<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\IrregularDepoEntity;

interface IrregularDepoRepositoryInterface
{
    /**
     * イレギュラー設定の取得
     *
     * @return array
     */
    public function findIrregularDepo(
        $irregularId
    ): array;

    /**
     * イレギュラーデポ登録
     *
     * @return array
     */
    public function save(
        IrregularDepoEntity $entity
    );
    
    /**
     * イレギュラーデポ削除（PK）
     *
     * @param integer $irregularDepoId
     * @param integer $loginCd
     * @return void
     */
    public function deleteById(
        int $irregularDepoId,
        int $loginCd
    );
    
    /**
     * イレギュラーデポ削除（irregularId）
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
