<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateDefaultValueIrregularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("UPDATE irregular SET error_message = 'dummy' WHERE error_message IS NULL");
        Schema::table('irregular', function (Blueprint $table) {
            // カラム定義
            $table->boolean('is_before_deadline_undeliv')->nullable()->default(true)->change();
            $table->boolean('is_today_deadline_undeliv')->nullable()->default(true)->change();
            $table->boolean('is_time_select_undeliv')->nullable()->default(true)->change();
            $table->boolean('is_personal_delivery')->nullable()->default(true)->change();
            $table->boolean('is_depo')->nullable()->default(false)->change();
            $table->boolean('is_item')->nullable()->default(false)->change();
            $table->boolean('is_area')->nullable()->default(false)->change();
            $table->string('error_message', 255)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('irregular', function (Blueprint $table) {
            // カラム定義
            $table->boolean('is_before_deadline_undeliv')->nullable()->change();
            $table->boolean('is_today_deadline_undeliv')->nullable()->change();
            $table->boolean('is_time_select_undeliv')->nullable()->change();
            $table->boolean('is_personal_delivery')->nullable()->change();
            $table->boolean('is_depo')->nullable()->change();
            $table->boolean('is_item')->nullable()->change();
            $table->boolean('is_area')->nullable()->change();
            $table->string('error_message', 255)->change();
        });
    }
}
