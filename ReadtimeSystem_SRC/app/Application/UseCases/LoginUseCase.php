<?php

namespace App\Application\UseCases;

use App\Consts\AppConst;
use App\Domain\Repositories\ViewLoginUserRepositoryInterface;
use Illuminate\Support\Facades\Config;

class LoginUseCase
{
    //UseCase User

    private $iViewLoginUserRepository;

    /**
     * コンストラクタ
     */
    public function __construct(
        ViewLoginUserRepositoryInterface $iViewLoginUserRepository
    ) {
        $this->iViewLoginUserRepository = $iViewLoginUserRepository;
    }

    /**
     * ログインユーザSession情報取得
     */
    public function findSessionInfo(int $loginCd, int $authCls)
    {
        $sessinInfo = null;
        if ($authCls == AppConst::AUTH_CLS['shain']) {
            $sessinInfo = $this->iViewLoginUserRepository->findLoginUserForShain($loginCd, $authCls);
        } else {
            $sessinInfo = $this->iViewLoginUserRepository->findLoginUserForDepo($loginCd, $authCls);
        }
        return $sessinInfo;
    }
}
