<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RenameDepoAddressLeadtimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('depo_address_leadtime', function (Blueprint $table) {
            $table->renameColumn('tue_before_deadline_flg', 'is_area_today_delivery_flg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('depo_address_leadtime', function (Blueprint $table) {
            $table->renameColumn('is_area_today_delivery_flg', 'tue_before_deadline_flg');
        });
    }
}
