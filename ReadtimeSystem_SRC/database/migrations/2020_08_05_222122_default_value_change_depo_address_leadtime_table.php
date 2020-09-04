<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DefaultValueChangeDepoAddressLeadtimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('depo_address_leadtime', function (Blueprint $table) {
            $table->boolean('is_area_today_delivery_flg')->nullable()->default(false)->change();
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
            $table->boolean('is_area_today_delivery_flg')->nullable()->change();
        });
    }
}
