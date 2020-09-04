<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadtimeDisplayGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leadtime_display_group', function (Blueprint $table) {
            // カラム定義
            $table->increments('display_group_id')->comment('表示グループID');
            $table->smallInteger('display_group_type')->nullable('false')->comment('表示グループ区分');
            $table->string('display_group_name', 20)->nullable('false')->comment('表示グループ名');
            $table->smallInteger('display_type')->nullable('false')->comment('表示タイプ');
            $table->boolean('rear_stand_flg')->nullable('false')->default('false')->comment('後立てフラグ');

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
        Schema::dropIfExists('leadtime_display_group');
    }
}
