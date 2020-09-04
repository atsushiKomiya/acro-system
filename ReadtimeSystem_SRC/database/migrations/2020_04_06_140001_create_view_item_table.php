<?php

use Illuminate\Database\Migrations\Migration;

class CreateViewItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<EOT
        CREATE VIEW view_item 
        (item_cd,
         item_name,
         keicho)
       AS SELECT
         item_site.item_cd,
         item_site.item_nm,
         item_sale.keicho
        FROM item_site
       INNER JOIN item_sale 
          ON item_site.item_cd = item_sale.item_cd
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
        DB::statement('DROP VIEW view_item');
    }
}
