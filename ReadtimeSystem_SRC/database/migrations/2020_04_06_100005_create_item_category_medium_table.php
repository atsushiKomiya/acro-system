<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemCategoryMediumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_category_medium', function (Blueprint $table) {
            // カラム定義
            $table->increments('category_medium_id')->comment('商品カテゴリ中ID');
            $table->integer('category_medium_cd')->nullable('false')->comment('商品カテゴリ中CD');
            $table->string('category_medium_name', 20)->nullable('false')->comment('商品カテゴリ中名称');
            $table->boolean('rear_stand_flg')->nullable('false')->comment('後立てフラグ');

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
        Schema::dropIfExists('item_category_medium');
    }
}
