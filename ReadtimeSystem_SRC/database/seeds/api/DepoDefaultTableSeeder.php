<?php

use Illuminate\Database\Seeder;

class DepoDefaultTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // デポカレンダーデフォルト

        $depo_cd = [
            399,
            907,
            7101,
            479
        ];
        $trans_depo_cd = [
            0,
            399,
            907,
            7101,
            479
        ];

        DB::table('depo_default')->truncate();

        foreach ($depo_cd as $cd) {
            if(($key = array_search($cd, $trans_depo_cd)) !== false) {
                unset($trans_depo_cd[$key]);
            }
            DB::table('depo_default')->insert([
                'depo_cd'                => $cd,
                'private_home_flg'       => rand(0, 1),
                'handing_flg'            => rand(0, 1),
                'congratulation_kbn_flg' => rand(1, 4),
                'transfer_post_depo_cd'  => $trans_depo_cd[array_rand($trans_depo_cd)],
                'depo_lead_time'         => rand(1, 4),
            ]);
        }

    }
}
