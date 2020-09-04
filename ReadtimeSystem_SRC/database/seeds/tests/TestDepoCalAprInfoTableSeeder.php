<?php

use Illuminate\Database\Seeder;
use App\Domain\Models\DepoCalAprInfo;

class TestDepoCalAprInfoTableSeeder extends Seeder
{
    private $eloquent;
    
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        // テストデータ

        DepoCalAprInfo::firstOrCreate(
            [
                'depo_cal_apr_id' => 1
            ],
            [
                'depo_cal_apr_id' => 1,
                'depo_cd' => '46',
                'date_ym' => '202008',
                'approval_date' => '2020-07-09',
                'approval_id' => '1',
                'confirm_flg' => '1',
            ]
        );

        DepoCalAprInfo::firstOrCreate(
            [
                'depo_cal_apr_id' => 2
            ],
            [
                'depo_cal_apr_id' => 2,
                'depo_cd' => '46',
                'date_ym' => '202009',
                'approval_date' => '2020-07-09',
                'approval_id' => '1',
                'confirm_flg' => '1',
            ]
        );

        DepoCalAprInfo::firstOrCreate(
            [
                'depo_cal_apr_id' => 3
            ],
            [
                'depo_cal_apr_id' => 3,
                'depo_cd' => '46',
                'date_ym' => '202010',
                'approval_date' => '2020-07-09',
                'approval_id' => '1',
                'confirm_flg' => '1',
            ]
        );

        DepoCalAprInfo::firstOrCreate(
            [
                'depo_cal_apr_id' => 4
            ],
            [
                'depo_cal_apr_id' => 4,
                'depo_cd' => '46',
                'date_ym' => '202011',
                'approval_date' => '2020-07-09',
                'approval_id' => '1',
                'confirm_flg' => '1',
            ]
        );

        DepoCalAprInfo::firstOrCreate(
            [
                'depo_cal_apr_id' => 5
            ],
            [
                'depo_cal_apr_id' => 5,
                'depo_cd' => '46',
                'date_ym' => '202012',
                'approval_date' => '2020-07-09',
                'approval_id' => '1',
                'confirm_flg' => '1',
            ]
        );

        DepoCalAprInfo::firstOrCreate(
            [
                'depo_cal_apr_id' => 6
            ],
            [
                'depo_cal_apr_id' => 6,
                'depo_cd' => '46',
                'date_ym' => '202101',
                'approval_date' => '2020-07-09',
                'approval_id' => '1',
                'confirm_flg' => '1',
            ]
        );

        DepoCalAprInfo::firstOrCreate(
            [
                'depo_cal_apr_id' => 7
            ],
            [
                'depo_cal_apr_id' => 7,
                'depo_cd' => '46',
                'date_ym' => '202102',
                'approval_date' => '2020-07-09',
                'approval_id' => '1',
                'confirm_flg' => '1',
            ]
        );

        DepoCalAprInfo::firstOrCreate(
            [
                'depo_cal_apr_id' => 8
            ],
            [
                'depo_cal_apr_id' => 8,
                'depo_cd' => '46',
                'date_ym' => '202103',
                'approval_date' => '2020-07-09',
                'approval_id' => '1',
                'confirm_flg' => '1',
            ]
        );

        DepoCalAprInfo::firstOrCreate(
            [
                'depo_cal_apr_id' => 9
            ],
            [
                'depo_cal_apr_id' => 9,
                'depo_cd' => '46',
                'date_ym' => '202104',
                'approval_date' => '2020-07-09',
                'approval_id' => '1',
                'confirm_flg' => '1',
            ]
        );

        DepoCalAprInfo::firstOrCreate(
            [
                'depo_cal_apr_id' => 10
            ],
            [
                'depo_cal_apr_id' => 10,
                'depo_cd' => '46',
                'date_ym' => '202105',
                'approval_date' => '2020-07-09',
                'approval_id' => '1',
                'confirm_flg' => '1',
            ]
        );

        DepoCalAprInfo::firstOrCreate(
            [
                'depo_cal_apr_id' => 11
            ],
            [
                'depo_cal_apr_id' => 11,
                'depo_cd' => '46',
                'date_ym' => '202106',
                'approval_date' => '2020-07-09',
                'approval_id' => '1',
                'confirm_flg' => '1',
            ]
        );

        DepoCalAprInfo::firstOrCreate(
            [
                'depo_cal_apr_id' => 12
            ],
            [
                'depo_cal_apr_id' => 12,
                'depo_cd' => '46',
                'date_ym' => '202107',
                'approval_date' => '2020-07-09',
                'approval_id' => '1',
                'confirm_flg' => '1',
            ]
        );

    }
}
