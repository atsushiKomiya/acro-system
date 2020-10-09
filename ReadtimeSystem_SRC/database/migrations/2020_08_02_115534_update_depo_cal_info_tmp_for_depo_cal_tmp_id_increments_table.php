<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateDepoCalInfoTmpForDepoCalTmpIdIncrementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement("DROP SEQUENCE IF EXISTS depo_cal_info_tmp_depo_cal_tmp_id_seq;");
        Schema::table('depo_cal_info_tmp', function (Blueprint $table) {
            // カラム定義
            $table->increments('depo_cal_tmp_id')->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP SEQUENCE depo_cal_info_tmp_depo_cal_tmp_id_seq;");
    }
}
