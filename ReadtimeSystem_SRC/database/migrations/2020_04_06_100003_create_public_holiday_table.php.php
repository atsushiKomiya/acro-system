<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicHolidayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_holiday', function (Blueprint $table) {
            // カラム定義
            $table->char('date',8)->nullable('false')->comment('日付');

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
        // テーブル削除
        Schema::dropIfExists('public_holiday');
    }
}
