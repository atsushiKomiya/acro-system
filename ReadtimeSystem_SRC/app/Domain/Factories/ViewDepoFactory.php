<?php
namespace App\Domain\Factories;

use App\Domain\Entities\ViewDepoEntity;
use App\Domain\Models\ViewDepo;

class ViewDepoFactory extends BaseFactory
{

    /**
     * ViewDepoEntity作成
     *
     * @param ViewDepo $viewDepo
     * @return ViewDepoEntity
     */
    public function make(ViewDepo $viewDepo): ViewDepoEntity
    {
        return new ViewDepoEntity(
            $viewDepo->depocd,
            $viewDepo->deponame,
            $viewDepo->display_group_type,
            $viewDepo->depo_type,
            $viewDepo->depo_pref,
            $viewDepo->depo_addr,
            $viewDepo->start_at,
            $viewDepo->end_at,
            $viewDepo->stop,
            null,
            null,
            null,
            null,
        );
    }

    /**
     * ViewDepo、LeadtimeDisplayGroup作成
     *
     * @param ViewDepo $viewDepo
     * @return ViewDepoEntity
     */
    public function makeDepoAndGroup(ViewDepo $viewDepo): ViewDepoEntity
    {
        return new ViewDepoEntity(
            $viewDepo->depocd,
            $viewDepo->deponame,
            $viewDepo->display_group_type,
            $viewDepo->depo_type,
            $viewDepo->depo_pref,
            $viewDepo->depo_addr,
            $viewDepo->start_at,
            $viewDepo->end_at,
            $viewDepo->stop,
            $viewDepo->display_group_id,
            $viewDepo->display_group_name,
            $viewDepo->display_type,
            $viewDepo->rear_stand_flg,
        );
    }

    /**
     * デポCD、デポ名称のみ設定する最小のEntityを生成する
     *
     * @param integer $depocd
     * @param string $deponame
     * @return ViewDepoEntity
     */
    public function makeDepoMinimum(int $depocd, string $deponame): ViewDepoEntity
    {
        return new ViewDepoEntity(
            $depocd,
            $deponame
        );
    }
}
