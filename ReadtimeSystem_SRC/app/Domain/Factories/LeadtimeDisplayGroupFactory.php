<?php
namespace App\Domain\Factories;

use App\Domain\Entities\DisplayGroupEntity;
use App\Domain\Models\LeadtimeDisplayGroup;

class LeadtimeDisplayGroupFactory
{

    /**
     * PrefEntity作成
     *
     * @param LeadtimeDisplayGroup $leadtimeDisplayGroup
     * @return DisplayGroupEntity
     */
    public function makeDisplayGroup(LeadtimeDisplayGroup $leadtimeDisplayGroup): DisplayGroupEntity
    {
        return new DisplayGroupEntity(
            $leadtimeDisplayGroup->display_group_type,
            $leadtimeDisplayGroup->display_group_name
        );
    }
}
