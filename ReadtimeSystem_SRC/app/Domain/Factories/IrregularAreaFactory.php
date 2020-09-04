<?php
namespace App\Domain\Factories;

use App\Domain\Entities\IrregularAreaEntity;
use App\Domain\Models\IrregularArea;

class IrregularAreaFactory
{

    /**
     * IrregularEntity作成
     *
     * @param Irregular $irregular
     * @return IrregularAreaEntity
     */
    public function make(IrregularArea $irregularArea): IrregularAreaEntity
    {
        $entity = new IrregularAreaEntity();
        $entity->irregularAreaId = $irregularArea->irregular_area_id;
        $entity->irregularId = $irregularArea->irregular_id;
        $entity->addrCd = $irregularArea->addr_cd;
        $entity->zipcode = $irregularArea->zipcode;
        $entity->prefCd = $irregularArea->pref_cd;
        $entity->siku = $irregularArea->siku;
        $entity->tyou = $irregularArea->tyou;
        $entity->prefName = $irregularArea->pref_name;
        return $entity;

    }
}
