<?php

use Illuminate\Database\Migrations\Migration;

class CreateViewLeadtimeMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<EOT
        CREATE VIEW view_leadtime_message
        AS SELECT
         message_id,
         depocd,
         message,
         view_limit,
         regist_at
        FROM s_to_depo_message
       WHERE message_group_id = '31'
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
        DB::statement('DROP VIEW view_leadtime_message');
    }
}
