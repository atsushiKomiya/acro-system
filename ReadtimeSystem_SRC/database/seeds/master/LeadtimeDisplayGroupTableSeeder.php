<?php

use App\Domain\Models\LeadtimeDisplayGroup;
use Illuminate\Database\Seeder;

class LeadtimeDisplayGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // 全削除
        LeadtimeDisplayGroup::truncate();

        // 通常
        LeadtimeDisplayGroup::firstOrCreate(
            [
                'display_group_type' => 1
            ],
            [
                'display_group_type' => 1,
                'display_group_name' => '通常',
                'display_type' => 1,
                'rear_stand_flg' => false,
            ]
        );
        // 郵便
        LeadtimeDisplayGroup::firstOrCreate(
            [
                'display_group_type' => 2
            ],
            [
                'display_group_type' => 2,
                'display_group_name' => '郵便',
                'display_type' => 3,
                'rear_stand_flg' => false,
            ]
        );
        // 生花
        LeadtimeDisplayGroup::firstOrCreate(
            [
                'display_group_type' => 3
            ],
            [
                'display_group_type' => 3,
                'display_group_name' => '生花',
                'display_type' => 3,
                'rear_stand_flg' => false,
            ]
        );
        // サプライズ
        LeadtimeDisplayGroup::firstOrCreate(
            [
                'display_group_type' => 4
            ],
            [
                'display_group_type' => 4,
                'display_group_name' => 'サプライズ',
                'display_type' => 2,
                'rear_stand_flg' => false,
            ]
        );
        // エンタメ
        LeadtimeDisplayGroup::firstOrCreate(
            [
                'display_group_type' => 5
            ],
            [
                'display_group_type' => 5,
                'display_group_name' => 'エンタメ',
                'display_type' => 3,
                'rear_stand_flg' => false,
            ]
        );
        // 胡蝶蘭A
        LeadtimeDisplayGroup::firstOrCreate(
            [
                'display_group_type' => 6
            ],
            [
                'display_group_type' => 6,
                'display_group_name' => '胡蝶蘭A',
                'display_type' => 3,
                'rear_stand_flg' => false,
            ]
        );
        // 胡蝶蘭B
        LeadtimeDisplayGroup::firstOrCreate(
            [
                'display_group_type' => 7
            ],
            [
                'display_group_type' => 7,
                'display_group_name' => '胡蝶蘭B',
                'display_type' => 3,
                'rear_stand_flg' => true,
            ]
        );
    }
}
