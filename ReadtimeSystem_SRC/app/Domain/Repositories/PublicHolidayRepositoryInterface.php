<?php

namespace App\Domain\Repositories;

interface PublicHolidayRepositoryInterface
{
    /**
     * 祝日リスト削除
     *
     * @return array
     */
    public function deletePublicHolidayList();

    /**
     * 祝日リスト登録
     *
     * @return array
     */
    public function inputPublicHolidayList($publicHolidayList);

    /**
     * 祝日リスト取得
     *
     * @return array
     */
    public function getPublicHolidayList();
}
