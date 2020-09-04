<?php
namespace App\Domain\Factories;

use App\Domain\Entities\CUseEntity;
use App\Domain\Models\CUse;

class CUseFactory
{

    /**
     * 用途Entity作成
     *
     * @param CUse $cUse
     * @return CUseEntity
     */
    public function makeCUse(CUse $cUse): CUseEntity
    {
        return new CUseEntity(
            $cUse->c_use,
            $cUse->keicho_type,
            $cUse->c_use_name
        );
    }
}
