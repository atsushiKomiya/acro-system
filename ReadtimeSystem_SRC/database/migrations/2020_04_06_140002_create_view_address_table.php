<?php

use Illuminate\Database\Migrations\Migration;

class CreateViewAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<EOT
        CREATE VIEW view_address
        (addrcd,
         jiscode,
         zipcode,
         pref,
         pref_name,
         siku,
         tyou)
        AS SELECT
         address.addrcd,
         address.jiscode,
         address.zipcode,
         address.pref,
         s_pref.pref_name,
         address.siku,
         address.tyou
        FROM address
       INNER JOIN s_pref 
          ON address.pref::int = s_pref.pref_id
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
        DB::statement('DROP VIEW view_address');
    }
}
