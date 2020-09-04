<?php

namespace App\Domain\Repositories;

use Illuminate\Support\LazyCollection;

use App\Domain\Entities\IrregularEntity;
use App\Domain\Entities\IrregularListSearchEntity;
use App\Domain\Entities\MessageSearchEntity;

interface IrregularRepositoryInterface
{

    /**
     * イレギュラーメッセージ一一覧取得
     *
     * @param MessageSearchEntity $entity
     * @return void
     */
    public function findAnnoMessageList(MessageSearchEntity $entity): array;

    /**
     * イレギュラー設定　取得
     * @param $irregularId
     * @return IrregularEntity
     */
    public function findIrregular($irregularId): IrregularEntity;

    /**
     * イレギュラー設定　登録/更新
     * @param IrregularEntity $irregularEntity
     * @return result
     */
    public function save(IrregularEntity $entity):int;

    /**
     * イレギュラー設定 削除
     *
     * @param integer $irregularId
     * @param integer $loginCd
     * @return void
     */
    public function deleteByIrregularId(int $irregularId,int $loginCd);

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * イレギュラー情報取得
     *
     * @param array $cond 検索条件
     * @return array
     */
    public function getIrregularInfo($cond);

    /**
     * イレギュラー情報リスト取得
     *
     * @param IrregularListSearchEntity $cond
     * @return LazyCollection
     */
    public function findIrregularList(IrregularListSearchEntity $cond): LazyCollection;
}
