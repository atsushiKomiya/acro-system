<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\LoginUserSessionEntity;

interface ViewLoginUserRepositoryInterface
{
    /**
     * 社員セッション元情報取得処理
     */
    public function findLoginUserForShain($loginCd, $authCls): ?LoginUserSessionEntity;

    /**
     * デポセッション元情報取得処理
     */
    public function findLoginUserForDepo($loginCd, $authCls): ?LoginUserSessionEntity;
}
