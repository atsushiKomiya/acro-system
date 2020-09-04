<?php

use Illuminate\Database\Migrations\Migration;

class CreateViewLoginUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<EOT
        CREATE VIEW view_login_user
        (view_login_user_id,
         login_cd,
         pass, 
         auth_cls)
        AS
        SELECT
            row_number() over() AS view_login_user_id,
            login_cd,
            pass, 
            auth_cls
        FROM (
            SELECT DISTINCT
                e_code AS login_cd
                ,regexp_replace(regexp_replace(pass, '\r|\n|\r\n', ''), '\r|\n|\r\n', '') AS pass
                ,1 AS auth_cls
            FROM h_shain
            INNER JOIN h_dep
            ON h_shain.d_code = h_dep.d_code
            UNION ALL
            SELECT DISTINCT
                depocd AS login_cd
                ,regexp_replace(regexp_replace(pass, '\r|\n|\r\n', ''), '\r|\n|\r\n', '') AS pass
                ,2 AS auth_cls
            FROM depocd
        ) AS tmp_login
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
        DB::statement('DROP VIEW view_login_user');
    }
}
