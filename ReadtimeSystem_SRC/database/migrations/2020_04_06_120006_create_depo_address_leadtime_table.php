<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepoAddressLeadtimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depo_address_leadtime', function (Blueprint $table) {
            // カラム定義
            $table->increments('depo_address_leadtime_id')->comment('デポ住所リードタイムID');
            $table->integer('depo_cd')->nullable('false')->comment('デポCD');
            $table->string('zip_cd', 7)->nullable('false')->comment('郵便番号');
            $table->string('pref_cd', 2)->nullable('false')->comment('都道府県CD');
            $table->string('jiscode', 8)->nullable('false')->comment('市区町村JIS');
            $table->string('siku', 40)->nullable('false')->comment('市区郡');
            $table->string('tyou', 100)->nullable('false')->comment('町名');
            $table->char('mon_today_delivery', 4)->nullable()->comment('翌日時間指定');
            $table->boolean('tue_before_deadline_flg')->nullable()->comment('エリア当日配送可否');
            $table->char('tue_today_delivery', 4)->nullable()->comment('翌日配送締切時間');
            $table->char('wed_before_deadline1', 4)->nullable()->comment('当日配送締切時間１');
            $table->char('wed_before_deadline2', 4)->nullable()->comment('当日配送締切時間２');

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
        Schema::dropIfExists('depo_address_leadtime');
    }
}
