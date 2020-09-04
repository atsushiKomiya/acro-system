<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\ViewDepoEntity;

interface ViewDepoRepositoryInterface
{
    /**
     * デポ取得
     *
     * @param int $depocd
     * @return ViewDepoEntity
     */
    public function findDepo(int $depocd): ?ViewDepoEntity;

    /**
     * デポ取得
     *
     * @param int $depocd
     * @return ViewDepoEntity
     */
    public function findViewDepo(int $depocd): ?ViewDepoEntity;


    /**
     * デポ一覧全件の取得
     *
     * @return array
     */
    public function findDepoListAll(): array;

    /**
     * 有効デポ情報取得
     *
     * @return array
     */
    public function getStartAtViewDepo();

    /**
     * 有効デポ情報取得（適用デポCDリスト使用）
     *
     * @return array
     */
    public function getStartAtViewDepoWithDepolist($depoList): array;

    /**
     * カレンダー更新対象デポリスト取得
     *
     * @return array
     */
    public function getUpdateTaisyoDepoList($currentYm, $checkMonth);
}
