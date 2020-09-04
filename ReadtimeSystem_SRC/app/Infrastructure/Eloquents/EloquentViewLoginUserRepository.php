<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Entities\LoginUserSessionEntity;
use App\Domain\Factories\ViewLoginUserFactory;
use App\Domain\Models\ViewLoginUser;
use App\Domain\Repositories\ViewLoginUserRepositoryInterface;

class EloquentViewLoginUserRepository implements ViewLoginUserRepositoryInterface
{
    // Model
    private $eloquent;
    // ファクトリを格納するプロパティ
    private $factory;

    /**
    * @param object $version
    */
    public function __construct(ViewLoginUser $loginUser, ViewLoginUserFactory $factory)
    {
        $this->eloquent = $loginUser;
        $this->factory = $factory;
    }

    /**
     * 社員セッション元情報取得処理
     */
    public function findLoginUserForShain($loginCd, $authCls): ?LoginUserSessionEntity
    {
        $result = null;

        $loginUser = $this->eloquent::select(
            'view_login_user.view_login_user_id AS view_login_user_id',
            'view_login_user.auth_cls AS auth_cls',
            'view_shain.e_code AS e_code',
            'view_shain.name1 AS name1',
            'view_shain.name2 AS name2',
            'view_shain.d_code AS d_code',
            'view_shain.d_name AS d_name',
        )
        ->join('view_shain', 'view_shain.e_code', '=', 'view_login_user.login_cd')
        ->where([
            ['view_login_user.login_cd' ,'=' ,$loginCd],
            ['view_login_user.auth_cls' ,'=' ,$authCls],
        ])
        ->first();

        if (!is_null($loginUser)) {
            $result = (new ViewLoginUserFactory)->makeShainUserSession(
                $loginUser->view_login_user_id,
                $loginUser->auth_cls,
                $loginUser->e_code,
                $loginUser->name1 . ' ' . $loginUser->name2,
                $loginUser->d_code,
                $loginUser->d_name,
            );
        }

        return $result;
    }

    /**
     * デポセッション元情報取得処理
     */
    public function findLoginUserForDepo($loginCd, $authCls): ?LoginUserSessionEntity
    {
        $result = null;

        $loginUser = $this->eloquent::select(
            'view_login_user.view_login_user_id AS view_login_user_id',
            'view_login_user.auth_cls AS auth_cls',
            'view_depo.depocd AS depocd',
            'view_depo.deponame AS deponame',
        )
        ->join('view_depo', 'view_depo.depocd', '=', 'view_login_user.login_cd')
        ->where([
            ['view_login_user.login_cd' ,'=' ,$loginCd],
            ['view_login_user.auth_cls' ,'=' ,$authCls],
        ])
        ->first();

        if (!is_null($loginUser)) {
            return (new ViewLoginUserFactory)->makeDepoUserSession(
                $loginUser->view_login_user_id,
                $loginUser->auth_cls,
                $loginUser->depocd,
                $loginUser->deponame,
            );
        }

        return $result;
    }
}
