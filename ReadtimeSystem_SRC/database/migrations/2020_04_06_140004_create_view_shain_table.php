<?php

use Illuminate\Database\Migrations\Migration;

class CreateViewShainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<EOT
        CREATE VIEW view_shain
        AS SELECT
         h_shain.e_code,
         h_shain.name1,
         h_shain.name2,
         h_shain.d_code,
         h_dep.d_name
        FROM h_shain 
       INNER JOIN h_dep
          ON h_shain.d_code = h_dep.d_code       
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
        DB::statement('DROP VIEW view_shain');
    }
}
