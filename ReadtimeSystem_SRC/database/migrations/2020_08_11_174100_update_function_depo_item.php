<?php

use Illuminate\Database\Migrations\Migration;

class UpdateFunctionDepoItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::statement('DROP FUNCTION func_depo_item(depo_cd text)');
        $sql = <<<EOT
        CREATE OR REPLACE FUNCTION func_depo_item(depo_cd text) RETURNS text AS $$
        DECLARE
          item_record record;
          tmp_cursor refcursor;
          tmp_record record;
          result_csv text;
          vSql text := '';
          i integer := 0;
        BEGIN
          vSql := vSql ||' SELECT CAST(array_agg(tmp3.*) AS text) AS csv FROM ( ';
          vSql := vSql ||' SELECT ';
          vSql := vSql ||'   tmp2.depo_cd ';
          FOR item_record IN ( SELECT count(item_name) FROM view_item GROUP BY item_cd, item_name ) LOOP
            i := i + 1;
            vSql := vSql ||'   , MAX(CASE WHEN tmp2.seq = ' || i || ' THEN tmp2.flg END) AS col_' || i;
          END LOOP;
          vSql := vSql ||' FROM ( ';
          vSql := vSql ||'   SELECT ';
          vSql := vSql ||'     tmp.depo_cd ';
          vSql := vSql ||'     , tmp.item_name ';
          vSql := vSql ||'     , tmp.flg ';
          vSql := vSql ||'     , ROW_NUMBER() OVER () AS seq ';
          vSql := vSql ||'   FROM ( ';
          vSql := vSql ||'     SELECT DISTINCT ';
          vSql := vSql ||'       ''' || depo_cd || ''' AS depo_cd ';
          vSql := vSql ||'       , item.item_cd ';
          vSql := vSql ||'       , item.item_name ';
          vSql := vSql ||'       , CASE WHEN info.depo_cd = ''' || depo_cd || ''' THEN 1 ELSE 0 END AS flg ';
          vSql := vSql ||'     FROM ';
          vSql := vSql ||'       ( SELECT DISTINCT item_cd, item_name , sale_status FROM view_item WHERE sale_status = ''0'' GROUP BY item_cd, item_name, sale_status ) AS item ';
          vSql := vSql ||'       LEFT JOIN ';
          vSql := vSql ||'         depo_item_info AS info ';
          vSql := vSql ||'       ON ';
          vSql := vSql ||'         item.item_cd = info.item_cd ';
          vSql := vSql ||'         AND info.depo_cd = ''' || depo_cd || '''';
          vSql := vSql ||'     WHERE ';
          vSql := vSql ||'       1 = 1 ';
          vSql := vSql ||'     GROUP BY ';
          vSql := vSql ||'       depo_cd ';
          vSql := vSql ||'       , item.item_cd ';
          vSql := vSql ||'       , item.item_name ';
          vSql := vSql ||'       , info.depo_cd ';
          vSql := vSql ||'     ORDER BY ';
          vSql := vSql ||'       item.item_cd ';
          vSql := vSql ||'   ) AS tmp ';
          vSql := vSql ||'   ORDER BY seq ';
          vSql := vSql ||' ) AS tmp2 ';
          vSql := vSql ||' GROUP BY ';
          vSql := vSql ||'   tmp2.depo_cd ';
          vSql := vSql ||') AS tmp3 ';
          
          result_csv := '';
          OPEN tmp_cursor FOR EXECUTE vSql;
          LOOP
            FETCH tmp_cursor INTO tmp_record;
            IF NOT FOUND THEN
              EXIT;
            END IF;
            result_csv := tmp_record.csv;
          END LOOP;
          CLOSE tmp_cursor;
          RETURN result_csv;
          END;
        $$ LANGUAGE plpgsql
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
        DB::statement('DROP FUNCTION func_depo_item(depo_cd text)');
        $sql = <<<EOT
        CREATE OR REPLACE FUNCTION func_depo_item(depo_cd text) RETURNS text AS $$
        DECLARE
          item_record record;
          tmp_cursor refcursor;
          tmp_record record;
          result_csv text;
          vSql text := '';
          i integer := 0;
        BEGIN
          vSql := vSql ||' SELECT CAST(array_agg(tmp3.*) AS text) AS csv FROM ( ';
          vSql := vSql ||' SELECT ';
          vSql := vSql ||'   tmp2.depo_cd ';
          FOR item_record IN ( SELECT count(item_name) FROM view_item GROUP BY item_cd, item_name ) LOOP
            i := i + 1;
            vSql := vSql ||'   , MAX(CASE WHEN tmp2.seq = ' || i || ' THEN tmp2.flg END) AS col_' || i;
          END LOOP;
          vSql := vSql ||' FROM ( ';
          vSql := vSql ||'   SELECT ';
          vSql := vSql ||'     tmp.depo_cd ';
          vSql := vSql ||'     , tmp.item_name ';
          vSql := vSql ||'     , tmp.flg ';
          vSql := vSql ||'     , ROW_NUMBER() OVER () AS seq ';
          vSql := vSql ||'   FROM ( ';
          vSql := vSql ||'     SELECT DISTINCT ';
          vSql := vSql ||'       ''' || depo_cd || ''' AS depo_cd ';
          vSql := vSql ||'       , item.item_cd ';
          vSql := vSql ||'       , item.item_name ';
          vSql := vSql ||'       , CASE WHEN info.depo_cd = ''' || depo_cd || ''' THEN 1 ELSE 0 END AS flg ';
          vSql := vSql ||'     FROM ';
          vSql := vSql ||'       ( SELECT DISTINCT item_cd, item_name FROM view_item GROUP BY item_cd, item_name ) AS item ';
          vSql := vSql ||'       LEFT JOIN ';
          vSql := vSql ||'         depo_item_info AS info ';
          vSql := vSql ||'       ON ';
          vSql := vSql ||'         item.item_cd = info.item_cd ';
          vSql := vSql ||'         AND info.depo_cd = ''' || depo_cd || '''';
          vSql := vSql ||'     WHERE ';
          vSql := vSql ||'       1 = 1 ';
          vSql := vSql ||'     GROUP BY ';
          vSql := vSql ||'       depo_cd ';
          vSql := vSql ||'       , item.item_cd ';
          vSql := vSql ||'       , item.item_name ';
          vSql := vSql ||'       , info.depo_cd ';
          vSql := vSql ||'     ORDER BY ';
          vSql := vSql ||'       item.item_cd ';
          vSql := vSql ||'   ) AS tmp ';
          vSql := vSql ||'   ORDER BY seq ';
          vSql := vSql ||' ) AS tmp2 ';
          vSql := vSql ||' GROUP BY ';
          vSql := vSql ||'   tmp2.depo_cd ';
          vSql := vSql ||') AS tmp3 ';
          
          result_csv := '';
          OPEN tmp_cursor FOR EXECUTE vSql;
          LOOP
            FETCH tmp_cursor INTO tmp_record;
            IF NOT FOUND THEN
              EXIT;
            END IF;
            result_csv := tmp_record.csv;
          END LOOP;
          CLOSE tmp_cursor;
          RETURN result_csv;
          END;
        $$ LANGUAGE plpgsql
EOT;

        DB::statement($sql);
    }
}
