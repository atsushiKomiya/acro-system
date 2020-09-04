<?php

use Illuminate\Database\Seeder;
use App\Domain\Models\DepoCalInfoTmp;

class TestDepoCalInfoTmpTableSeeder extends Seeder
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

        DepoCalInfoTmp::firstOrCreate(
            [
                'depo_cal_tmp_id' => 1
            ],
            [
                'depo_cal_tmp_id' => 1,
                'depo_cd' => '46',
                'delivery_date' => '20200803',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '2',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1200',
                'dayofweek' => '1',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
                'approval_flg' => true,

            ]
        );

        DepoCalInfoTmp::firstOrCreate(
            [
                'depo_cal_tmp_id' => 2
            ],
            [
                'depo_cal_tmp_id' => 2,
                'depo_cd' => '46',
                'delivery_date' => '20200804',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '0',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '2',
                'public_holiday_status' => '0',
                'annotation_depo' => null,
                'annotation_disp' => null,
                'approval_flg' => false,

            ]
        );

        DepoCalInfoTmp::firstOrCreate(
            [
                'depo_cal_tmp_id' => 3
            ],
            [
                'depo_cal_tmp_id' => 3,
                'depo_cd' => '46',
                'delivery_date' => '20200807',
                'before_deadline_flg' => '0',
                'today_delivery_flg' => '0',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '5',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
                'approval_flg' => false,

            ]
        );
    }
}
