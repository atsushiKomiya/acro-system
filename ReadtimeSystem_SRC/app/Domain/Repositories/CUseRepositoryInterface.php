<?php

namespace App\Domain\Repositories;

interface CUseRepositoryInterface
{

    /**
     * 用途リストの取得
     *
     * @return array
     */
    public function findCUseList(): array;
}
