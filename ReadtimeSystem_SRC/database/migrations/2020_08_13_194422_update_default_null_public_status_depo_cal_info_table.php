<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDefaultNullPublicStatusDepoCalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('depo_cal_info', function (Blueprint $table) {
            $table->string('public_holiday_status', 1)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('depo_cal_info', function (Blueprint $table) {
            $table->string('public_holiday_status', 1)->nullable('false')->change();
        });
    }
}
