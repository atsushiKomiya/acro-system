<?php

use Illuminate\Database\Seeder;

class DepoCalInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('depo_cal_info')->truncate();

        // デポカレンダー情報作成
        $depo_cd = [
            399,
            907,
            7101,
            479
        ];
        $days = [
            1,2,3,4,5,6,7
        ];
        $before_deadline_flg = [
            0,1,2
        ];
        $today_delivery_flg = [
            0,1,2
        ];
        $public_holiday_status = [
            1,2,3,4
        ];
        $annotation_depo = [
            '申込画面表示注釈1',
            '申込画面表示注釈2',
            '申込画面表示注釈3',
            '申込画面表示注釈4',
            '申込画面表示注釈5',
        ];
        $annotation_disp = [
            '申込画面表示注釈（表示）1',
            '申込画面表示注釈（表示）2',
            '申込画面表示注釈（表示）3',
            '申込画面表示注釈（表示）4',
            '申込画面表示注釈（表示）5',
        ];
        $before_deadline_limit_time = [
            1200,
            1800,
            2200,
        ];
        $today_deadline_limit_time = [
             800,
            1200,
            1600,
        ];

        $cnt = count($depo_cd) * count($days);

        for ($i=0; $i<=$cnt; $i++) {
            $day = array_rand($days);

            DB::table('depo_cal_info')->insert([
                'depo_cd'                    => $depo_cd[array_rand($depo_cd)],
                'delivery_date'              => date('Ymd', strtotime("-{$day} day")),
                'before_deadline_flg'        => $before_deadline_flg[array_rand($before_deadline_flg)],
                'today_delivery_flg'         => $today_delivery_flg[array_rand($today_delivery_flg)],
                'before_deadline_limit_time' => $before_deadline_limit_time[array_rand($before_deadline_limit_time)],
                'today_deadline_limit_time'  => $today_deadline_limit_time[array_rand($today_deadline_limit_time)],
                'dayofweek'                  => date('w', strtotime("-{$day} day")),
                'public_holiday_status'      => $public_holiday_status[array_rand($public_holiday_status)],
                'annotation_depo'            => $annotation_depo[array_rand($annotation_depo)],
                'annotation_disp'            => $annotation_disp[array_rand($annotation_disp)],
            ]);
        }

    }
}
