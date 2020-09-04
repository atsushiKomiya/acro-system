<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIrregularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('irregular', function (Blueprint $table) {
            // カラム定義
            $table->increments('irregular_id')->comment('イレギュラーID');
            $table->string('title', 100)->nullable('false')->comment('タイトル');
            $table->smallInteger('irregular_type')->nullable('false')->comment('イレギュラー設定区分');
            $table->smallInteger('c_use')->nullable()->comment('用途CD');
            $table->boolean('is_valid')->nullable('false')->default(true)->comment('有効フラグ');
            $table->boolean('is_before_deadline_undeliv')->nullable()->comment('前日締切不可フラグ');
            $table->boolean('is_today_deadline_undeliv')->nullable()->comment('当日配送不可フラグ');
            $table->boolean('is_time_select_undeliv')->nullable()->comment('時間指定不可フラグ');
            $table->smallInteger('time_select')->nullable()->comment('時間指定');

            $table->boolean('is_personal_delivery')->nullable()->comment('個人宅不可フラグ');
            $table->smallInteger('delivery_date_type')->nullable()->comment('お届け期間・曜日区分');
            $table->date('delivery_date')->nullable()->comment('お届け日');
            $table->date('delivery_date_from')->nullable()->comment('お届け開始日');
            $table->date('delivery_date_to')->nullable()->comment('お届け終了日');
            $table->smallInteger('order_date_type')->nullable()->comment('受注期間・曜日区分');
            $table->date('order_date')->nullable()->comment('受注日');
            $table->date('order_date_from')->nullable()->comment('受注開始日');
            $table->date('order_date_to')->nullable()->comment('受注終了日');
            $table->boolean('is_depo')->nullable()->comment('デポ指定フラグ');
            $table->boolean('is_item')->nullable()->comment('商品指定フラグ');
            $table->boolean('is_area')->nullable()->comment('地域指定フラグ');
            $table->date('anno_from')->nullable()->comment('赤字表示開始日');
            $table->date('anno_to')->nullable()->comment('赤字表示終了日');
            $table->string('anno_addr', 255)->nullable()->comment('地域注釈');
            $table->string('anno_period', 255)->nullable()->comment('期間注釈');
            $table->string('anno_trans', 255)->nullable()->comment('振替注釈');
            $table->string('error_message', 255)->nullable()->comment('エラーメッセージ');
            $table->smallInteger('trans_depo_cd')->nullable()->comment('振替先配送デポCD');
            $table->string('remark', 255)->nullable()->comment('備考');

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
        Schema::dropIfExists('irregular');
    }
}
