<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIrregularDayofweekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('irregular_dayofweek', function (Blueprint $table) {
            // カラム定義
            $table->increments('irregular_dayofweek_id')->comment('イレギュラー曜日ID');
            $table->integer('irregular_id')->nullable('false')->comment('イレギュラーID');
            $table->smallInteger('date_type')->nullable('false')->comment('日付区分');
            $table->smallInteger('dayofweek')->nullable()->comment('曜日');
            $table->smallInteger('public_holiday_status')->nullable()->comment('祝日ステータス');

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
        Schema::dropIfExists('irregular_dayofweek');
    }
}
