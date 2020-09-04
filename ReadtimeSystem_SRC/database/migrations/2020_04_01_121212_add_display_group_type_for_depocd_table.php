<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisplayGroupTypeForDepocdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('depocd', function (Blueprint $table) {
            // カラム定義
            $table->smallInteger('display_group_type')->nullable('false')->default(1)->comment('表示グループ区分');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('depocd', function (Blueprint $table) {
            // カラム定義
            $table->dropColumn('display_group_type');
        });
    }
}
