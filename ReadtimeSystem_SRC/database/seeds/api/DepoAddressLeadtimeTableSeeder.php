<?php

use Illuminate\Database\Seeder;

class DepoAddressLeadtimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // デポ住所リードタイム情報
        $depo_cd = [
            399,
            907,
            7101,
            479
        ];
        $next_day_time_type = [
            0,1000,1030,1100,1130,1200,1230,1259,1300,1330,1400,1430,1500,1530,1600,1630,1700,1730,1800,1830,1900
        ];

        DB::table('depo_address_leadtime')->truncate();

        foreach ($depo_cd as $cd) {
            DB::table('depo_address_leadtime')->insert([
                'depo_cd'                 => $cd,
                'next_day_time_type'      => $next_day_time_type[array_rand($next_day_time_type)],
                'tue_before_deadline_flg' => rand(0, 1),
                'next_day_time_deadline'  => rand(9, 12),
                'today_time_deadline1'    => rand(9, 12),
                'today_time_deadline2'    => rand(9, 12),
            ]);
        }

    }
}
