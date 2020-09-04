<?php
namespace App\Domain\Factories;

use App\Domain\Entities\IrregularDepoEntity;
use App\Domain\Models\IrregularDepo;

class IrregularDepoFactory
{

    /**
     * IrregularEntity作成
     *
     * @param Irregular $irregular
     * @return IrregularDepoEntity
     */
    public function make(IrregularDepo $irregularDepo): IrregularDepoEntity
    {
        $entity = new IrregularDepoEntity();
        $entity->irregularDepoId = $irregularDepo->irregular_depo_id;
        $entity->irregularId = $irregularDepo->irregular_id;
        $entity->depoCd = $irregularDepo->depocd;
        $entity->depoName = $irregularDepo->deponame;

        return $entity;
    }
}
