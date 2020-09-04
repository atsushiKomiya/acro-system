<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepoCalAprInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depo_cal_apr_info', function (Blueprint $table) {
            // カラム定義
            $table->increments('depo_cal_apr_id')->comment('デポカレンダー承認ID');
            $table->integer('depo_cd')->nullable('false')->comment('デポCD');
            $table->date('date_ym')->nullable('false')->comment('年月');
            $table->timestamp('approval_date')->nullable()->comment('作成日時');
            $table->integer('approval_id')->nullable()->comment('承認者ID');
            $table->boolean('confirm_flg')->nullable('false')->default('false')->comment('確認フラグ');

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
        Schema::dropIfExists('depo_cal_apr_info');
    }
}
