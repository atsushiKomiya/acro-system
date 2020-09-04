<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepoCalInfoTmpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depo_cal_info_tmp', function (Blueprint $table) {
            // カラム定義
            $table->integer('depo_cal_tmp_id')->nullable('false')->comment('デポカレンダーtmpID');
            $table->integer('depo_cd')->nullable('false')->comment('デポCD');
            $table->string('delivery_date', 8)->nullable('false')->comment('届日（日付）');
            $table->string('before_deadline_flg', 1)->nullable('false')->comment('前日締切フラグ');
            $table->string('today_delivery_flg', 1)->nullable('false')->comment('当日配送可フラグ');
            $table->time('before_deadline_limit_time', 8)->nullable()->comment('前日締切締め時間');
            $table->time('today_deadline_limit_time', 8)->nullable()->comment('当日配送締め時間');
            $table->string('dayofweek', 1)->nullable('false')->comment('曜日');
            $table->string('public_holiday_status', 1)->nullable('false')->comment('祝日ステータス');
            $table->text('annotation_depo')->nullable()->comment('申込画面表示注釈');
            $table->text('annotation_disp')->nullable()->comment('申込画面表示注釈（表示）');
            $table->boolean('approval_flg')->nullable()->comment('承認フラグ');

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
        Schema::dropIfExists('depo_cal_info_tmp');
    }
}
