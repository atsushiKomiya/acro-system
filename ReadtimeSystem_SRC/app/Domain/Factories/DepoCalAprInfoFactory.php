<?php
namespace App\Domain\Factories;

use App\Domain\Entities\DepoCalAprInfoEntity;
use App\Domain\Models\DepoCalAprInfo;

class DepoCalAprInfoFactory extends BaseFactory
{
    /**
     * カレンダー承認情報作成
     *
     * @param DepoCalAprInfo $depoCalAprInfo
     * @return DepoCalAprInfoEntity
     */
    public function makeDepoCalAprInfo(DepoCalAprInfo $depoCalAprInfo): DepoCalAprInfoEntity
    {
        $entity = new DepoCalAprInfoEntity();
        $entity->approvalDate = $depoCalAprInfo->approval_date;
        $entity->confirmFlg = $depoCalAprInfo->confirm_flg;

        return $entity;
    }

    /**
     * 削除年月取得
     *
     * @param DepoCalAprInfo $depoCalAprInfo
     * @return DepoCalAprInfoEntity
     */
    public function makeDeleteMonth(DepoCalAprInfo $depoCalAprInfo): DepoCalAprInfoEntity
    {
        $entity = new DepoCalAprInfoEntity();
        $entity->approvalDate = $depoCalAprInfo->approval_date;
        return  $entity;
    }
}
