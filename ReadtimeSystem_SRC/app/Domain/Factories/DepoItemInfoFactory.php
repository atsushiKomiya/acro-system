<?php
namespace App\Domain\Factories;

use App\Domain\Entities\DepoItemInfoEntity;
use App\Domain\Models\DepoItemInfo;
use Illuminate\Database\Eloquent\Model;

class DepoItemInfoFactory
{

    /**
     * 検索結果表示用Entityの作成
     *
     * @param DepoItemInfo $depoItemInfo
     * @return DepoItemInfoEntity
     */
    public function makeSearchEntity(DepoItemInfo $depoItemInfo): DepoItemInfoEntity
    {
        $entity = new DepoItemInfoEntity();
        $entity->depoItemInfoId         = $depoItemInfo['depo_item_info_id'];
        $entity->depoCd                 = $depoItemInfo['depo_cd'];
        $entity->itemCategoryLargeCd    = $depoItemInfo['category_large_cd'];
        $entity->itemCategoryLargeName  = $depoItemInfo['category_large_name'];
        $entity->itemCategoryMediumCd   = $depoItemInfo['category_medium_cd'];
        $entity->itemCategoryMediumName = $depoItemInfo['category_medium_name'];
        $entity->itemCd                = $depoItemInfo['item_cd'];
        $entity->itemName              = $depoItemInfo['item_name'];

        $entity->setActionLog($depoItemInfo);
        return $entity;
    }
    /**
     * 画面からの登録時に使用するEntityを作成する
     *
     * @param Model $model
     * @return DepoItemInfoEntity
     */
    public function makeUpdate(
        $depoCd,
        $itemCd
    ): DepoItemInfoEntity {
        $entity = new DepoItemInfoEntity();
        $entity->depoCd = $depoCd;
        $entity->itemCd = $itemCd;
        return $entity;
    }

    /**
     * リードタイムアドレス情報テーブル保存用のEntityを作成する
     *
     * @param Model $model
     * @return DepoItemInfoEntity
     */
    public function makeDefaultLeadtimeCsv(
        $depoItemInfoId,
        $depoCd,
        $itemCd
    ): DepoItemInfoEntity {
        $entity = new DepoItemInfoEntity();
        $entity->depoItemInfoId = $depoItemInfoId;
        $entity->depoCd = $depoCd;
        $entity->itemCd = $itemCd;
        return $entity;
    }
}
