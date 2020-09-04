<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIrregularAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('irregular_area', function (Blueprint $table) {
            // カラム定義
            $table->increments('irregular_area_id')->comment('イレギュラー地域ID');
            $table->integer('irregular_id')->nullable('false')->comment('イレギュラーID');
            $table->integer('addr_cd')->nullable()->comment('住所CD');
            $table->string('zip_cd', 7)->nullable()->comment('郵便番号');
            $table->string('pref_cd', 2)->nullable()->comment('都道府県CD');
            $table->string('siku', 40)->nullable()->comment('市区郡');
            $table->string('tyou', 100)->nullable()->comment('町名');

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
        Schema::dropIfExists('irregular_area');
    }
}
