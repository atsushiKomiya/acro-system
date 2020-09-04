<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepoDefaultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depo_default', function (Blueprint $table) {
            // カラム定義
            $table->increments('depo_default_id')->comment('デポカレンダーデフォルトID');
            $table->integer('depo_cd')->nullable('false')->comment('デポCD');
            $table->boolean('mon_before_deadline_flg')->nullable('false')->default('false')->comment('月_前日締切可フラグ');
            $table->boolean('mon_today_delivery_flg')->nullable('false')->default('false')->comment('月_当日配送可フラグ');
            $table->boolean('tue_before_deadline_flg')->nullable('false')->default('false')->comment('火_前日締切可フラグ');
            $table->boolean('tue_today_delivery_flg')->nullable('false')->default('false')->comment('火_当日配送可フラグ');
            $table->boolean('wed_before_deadline_flg')->nullable('false')->default('false')->comment('水_前日締切可フラグ');
            $table->boolean('wed_today_delivery_flg')->nullable('false')->default('false')->comment('水_当日配送可フラグ');
            $table->boolean('thu_before_deadline_flg')->nullable('false')->default('false')->comment('木_前日締切可フラグ');
            $table->boolean('thu_today_delivery_flg')->nullable('false')->default('false')->comment('木_当日配送可フラグ');
            $table->boolean('fri_before_deadline_flg')->nullable('false')->default('false')->comment('金_前日締切可フラグ');
            $table->boolean('fri_today_delivery_flg')->nullable('false')->default('false')->comment('金_当日配送可フラグ');
            $table->boolean('sat_before_deadline_flg')->nullable('false')->default('false')->comment('土_前日締切可フラグ');
            $table->boolean('sat_today_delivery_flg')->nullable('false')->default('false')->comment('土_当日配送可フラグ');
            $table->boolean('sun_before_deadline_flg')->nullable('false')->default('false')->comment('日_前日締切可フラグ');
            $table->boolean('sun_today_delivery_flg')->nullable('false')->default('false')->comment('日_当日配送可フラグ');
            $table->boolean('holi_before_deadline_flg')->nullable('false')->default('false')->comment('祝前_前日締切可フラグ');
            $table->boolean('holi_before_today_delivery_flg')->nullable('false')->default('false')->comment('祝前_当日配送可フラグ');
            $table->boolean('holi_deadline_flg')->nullable('false')->default('false')->comment('祝日_前日締切可フラグ');
            $table->boolean('holi_today_delivery_flg')->nullable('false')->default('false')->comment('祝日_当日配送可フラグ');
            $table->boolean('holi_after_deadline_flg')->nullable('false')->default('false')->comment('祝後_前日締切可フラグ');
            $table->boolean('holi_after_today_delivery_flg')->nullable('false')->default('false')->comment('祝後_当日配送可フラグ');
            $table->boolean('private_home_flg')->nullable('false')->default('false')->comment('個人宅可フラグ');
            $table->boolean('handing_flg')->nullable('false')->default('false')->comment('手持ちお届け可フラグ');
            $table->string('congratulation_kbn_flg', 1)->nullable('false')->comment('慶弔区分可否ステータス');
            $table->integer('transfer_post_depo_cd')->nullable('false')->default(1)->comment('振替先郵便デポCD');
            $table->smallInteger('depo_lead_time')->nullable('false')->default(1)->comment('デポリードタイム');

            // 共通
            $table->integer('created_id')->nullable()->comment('登録者ID');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->integer('updated_id')->nullable()->comment('更新者ID');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->integer('deleted_id')->nullable()->comment('削除者ID');
            $table->softDeletes()->nullable()->comment('削除日時');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depo_default');
    }
}
