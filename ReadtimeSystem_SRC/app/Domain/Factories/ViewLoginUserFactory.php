<?php
namespace App\Domain\Factories;

use App\Domain\Entities\LoginUserSessionEntity;

class ViewLoginUserFactory
{
    /**
     * 社員用のSessionEntityを作成する
     *
     * @param integer $viewLoginUserId
     * @param integer $authCls
     * @param string $eCd
     * @param string $eName
     * @param integer $dCode
     * @param string $dName
     * @return LoginUserSessionEntity
     */
    public function makeShainUserSession(
        int $viewLoginUserId,
        int $authCls,
        string $eCd,
        string $eName,
        int $dCode,
        string $dName
    ): LoginUserSessionEntity {
        return new LoginUserSessionEntity(
            $viewLoginUserId,
            $authCls,
            $eCd,
            $eName,
            $dCode,
            $dName,
            null,
            null,
            null
        );
    }

    /**
     * 社員用のSessionEntityを作成する
     *
     * @param integer $viewLoginUserId
     * @param integer $authCls
     * @param integer $depoCd
     * @param string $depoName
     * @return LoginUserSessionEntity
     */
    public function makeDepoUserSession(
        int $viewLoginUserId,
        int $authCls,
        int $depoCd,
        string $depoName
    ): LoginUserSessionEntity {
        return new LoginUserSessionEntity(
            $viewLoginUserId,
            $authCls,
            null,
            null,
            null,
            null,
            $depoCd,
            $depoName,
            null
        );
    }
}
