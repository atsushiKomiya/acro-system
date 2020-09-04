<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateDepoCalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE depo_cal_info ALTER COLUMN before_deadline_limit_time TYPE INTEGER USING 0;');
        DB::statement('ALTER TABLE depo_cal_info ALTER COLUMN today_deadline_limit_time TYPE INTEGER USING 0;');

        Schema::table('depo_cal_info', function (Blueprint $table) {
            // カラム定義
            $table->integer('before_deadline_limit_time')->nullable('false')->default(0)->change();
            $table->integer('today_deadline_limit_time')->nullable('false')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 制約を外してから
        Schema::table('depo_cal_info', function (Blueprint $table) {
            // カラム定義
            $table->integer('before_deadline_limit_time')->nullable()->default(null)->change();
            $table->integer('today_deadline_limit_time')->nullable()->default(null)->change();
        });
        DB::statement('ALTER TABLE depo_cal_info ALTER COLUMN before_deadline_limit_time TYPE TIME USING NULL;');
        DB::statement('ALTER TABLE depo_cal_info ALTER COLUMN today_deadline_limit_time TYPE TIME USING NULL;');
    }
}
