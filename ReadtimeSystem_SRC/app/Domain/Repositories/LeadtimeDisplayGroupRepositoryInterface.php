<?php

namespace App\Domain\Repositories;

interface LeadtimeDisplayGroupRepositoryInterface
{

    /**
     * 表示グループ区分リストの取得
     *
     * @return array
     */
    public function findDisplayGroupList(): array;
}
