<?php

use Illuminate\Database\Seeder;

class CUseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('c_use')->truncate();

        // 用途
        for ($i=1; $i<=99; $i++) {
            DB::table('c_use')->insert([
                'c_use'       => $i,
                'keicho_type' => rand(1, 2),
                'c_use_name'  => "用途名".$i,
            ]);
        }

    }
}
