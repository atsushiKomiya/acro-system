<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDepoCalAprInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE depo_cal_apr_info ALTER COLUMN date_ym TYPE VARCHAR(6) USING to_char(date_ym,'yyyyMM');");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE depo_cal_apr_info ALTER COLUMN date_ym TYPE DATE USING to_date(date_ym,'yyyyMM');");
    }
}
