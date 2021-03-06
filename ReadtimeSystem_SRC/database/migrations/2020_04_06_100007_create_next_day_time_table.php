<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNextDayTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('next_day_time', function (Blueprint $table) {
            // カラム定義
            $table->increments('next_day_time_id')->comment('翌日時間指定ID');
            $table->string('next_day_time', 10)->nullable('false')->comment('翌日時間指定');
            $table->string('next_day_time_value', 10)->nullable('false')->comment('翌日時間指定表示値');
            $table->smallInteger('leadtime')->nullable('false')->comment('リードタイム');
            $table->string('type_value', 5)->nullable('false')->comment('区分値');

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
        Schema::dropIfExists('next_day_time');
    }
}
