<?php

use Illuminate\Database\Migrations\Migration;

class CreateViewDepoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<EOT
        CREATE VIEW view_depo
        AS SELECT
         depocd, 
         deponame,
         display_group_type,
         depo_type,
         depo_pref,
         depo_addr,
         start_at,
         end_at,
         stop
        FROM depocd
EOT;

        DB::statement($sql);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW view_depo');
    }
}
