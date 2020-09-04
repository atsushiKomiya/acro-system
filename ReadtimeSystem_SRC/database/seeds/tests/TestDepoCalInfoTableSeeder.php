<?php

use Illuminate\Database\Seeder;
use App\Domain\Models\DepoCalInfo;

class TestDepoCalInfoTableSeeder extends Seeder
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
        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 1
            ],
            [
                'depo_cal_id' => 1,
                'depo_cd' => '46',
                'delivery_date' => '20200801',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '6',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 2
            ],
            [
                'depo_cal_id' => 2,
                'depo_cd' => '46',
                'delivery_date' => '20200802',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '0',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 3
            ],
            [
                'depo_cal_id' => 3,
                'depo_cd' => '46',
                'delivery_date' => '20200803',
                'before_deadline_flg' => '2',
                'today_delivery_flg' => '2',
                'before_deadline_limit_time' => '1300',
                'today_deadline_limit_time' => '1300',
                'dayofweek' => '1',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 4
            ],
            [
                'depo_cal_id' => 4,
                'depo_cd' => '46',
                'delivery_date' => '20200804',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '2',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 5
            ],
            [
                'depo_cal_id' => 5,
                'depo_cd' => '46',
                'delivery_date' => '20200805',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '3',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 6
            ],
            [
                'depo_cal_id' => 6,
                'depo_cd' => '46',
                'delivery_date' => '20200806',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '4',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 7
            ],
            [
                'depo_cal_id' => 7,
                'depo_cd' => '46',
                'delivery_date' => '20200807',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '5',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 8
            ],
            [
                'depo_cal_id' => 8,
                'depo_cd' => '46',
                'delivery_date' => '20200808',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '6',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 9
            ],
            [
                'depo_cal_id' => 9,
                'depo_cd' => '46',
                'delivery_date' => '20200809',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '0',
                'public_holiday_status' => '2',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 10
            ],
            [
                'depo_cal_id' => 10,
                'depo_cd' => '46',
                'delivery_date' => '20200810',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '1',
                'public_holiday_status' => '1',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 11
            ],
            [
                'depo_cal_id' => 11,
                'depo_cd' => '46',
                'delivery_date' => '20200811',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '2',
                'public_holiday_status' => '3',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 12
            ],
            [
                'depo_cal_id' => 12,
                'depo_cd' => '46',
                'delivery_date' => '20200812',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '3',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 13
            ],
            [
                'depo_cal_id' => 13,
                'depo_cd' => '46',
                'delivery_date' => '20200813',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '4',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 14
            ],
            [
                'depo_cal_id' => 14,
                'depo_cd' => '46',
                'delivery_date' => '20200814',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '5',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 15
            ],
            [
                'depo_cal_id' => 15,
                'depo_cd' => '46',
                'delivery_date' => '20200815',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '6',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 16
            ],
            [
                'depo_cal_id' => 16,
                'depo_cd' => '46',
                'delivery_date' => '20200816',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '0',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 17
            ],
            [
                'depo_cal_id' => 17,
                'depo_cd' => '46',
                'delivery_date' => '20200817',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '1',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 18
            ],
            [
                'depo_cal_id' => 18,
                'depo_cd' => '46',
                'delivery_date' => '20200818',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '2',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 19
            ],
            [
                'depo_cal_id' => 19,
                'depo_cd' => '46',
                'delivery_date' => '20200819',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '3',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 20
            ],
            [
                'depo_cal_id' => 20,
                'depo_cd' => '46',
                'delivery_date' => '20200820',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '4',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 21
            ],
            [
                'depo_cal_id' => 21,
                'depo_cd' => '46',
                'delivery_date' => '20200821',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '5',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 22
            ],
            [
                'depo_cal_id' => 22,
                'depo_cd' => '46',
                'delivery_date' => '20200822',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '6',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 23
            ],
            [
                'depo_cal_id' => 23,
                'depo_cd' => '46',
                'delivery_date' => '20200823',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '0',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 24
            ],
            [
                'depo_cal_id' => 24,
                'depo_cd' => '46',
                'delivery_date' => '20200824',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '1',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 25
            ],
            [
                'depo_cal_id' => 25,
                'depo_cd' => '46',
                'delivery_date' => '20200825',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '2',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 26
            ],
            [
                'depo_cal_id' => 26,
                'depo_cd' => '46',
                'delivery_date' => '20200826',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '3',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 27
            ],
            [
                'depo_cal_id' => 27,
                'depo_cd' => '46',
                'delivery_date' => '20200827',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '4',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 28
            ],
            [
                'depo_cal_id' => 28,
                'depo_cd' => '46',
                'delivery_date' => '20200828',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '5',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 29
            ],
            [
                'depo_cal_id' => 29,
                'depo_cd' => '46',
                'delivery_date' => '20200829',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '6',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 30
            ],
            [
                'depo_cal_id' => 30,
                'depo_cd' => '46',
                'delivery_date' => '20200830',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '0',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );

        DepoCalInfo::firstOrCreate(
            [
                'depo_cal_id' => 31
            ],
            [
                'depo_cal_id' => 31,
                'depo_cd' => '46',
                'delivery_date' => '20200831',
                'before_deadline_flg' => '1',
                'today_delivery_flg' => '1',
                'before_deadline_limit_time' => '1000',
                'today_deadline_limit_time' => '1000',
                'dayofweek' => '1',
                'public_holiday_status' => '4',
                'annotation_depo' => null,
                'annotation_disp' => null,
            ]
        );
    }
}
