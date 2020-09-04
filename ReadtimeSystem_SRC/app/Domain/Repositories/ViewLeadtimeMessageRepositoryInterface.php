<?php

namespace App\Domain\Repositories;

interface ViewLeadtimeMessageRepositoryInterface
{
    /**
     * 文言通知取得
     *
     * @param string $date
     * @return array
     */
    public function findInfoMessageList(string $date): array;
}
