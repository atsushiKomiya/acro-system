<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunctionTsunen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ストアド作成

        /** 通年from */
        DB::statement(
            "CREATE OR REPLACE FUNCTION tsunen_from(pDateFrom date)
            RETURNS date AS
            '
            BEGIN
                CASE
                    WHEN to_char( pDateFrom, ''YYYY'') = ''1910'' THEN
                        pDateFrom := to_char(current_timestamp, ''YYYY'') || ''-'' || to_char(pDateFrom, ''MM'') || ''-'' || to_char(pDateFrom, ''DD'');
                ELSE pDateFrom := pDateFrom;
                END CASE;
                RETURN pDateFrom;
            END
            '
            LANGUAGE 'plpgsql'"
        );
        /** 通年to */
        DB::statement(
            "CREATE OR REPLACE FUNCTION tsunen_to(pDateFrom date, pDateTo date)
            RETURNS date AS
            '
            BEGIN
                CASE
                    WHEN to_char( pDateFrom, ''YYYY'') = ''1910'' THEN
                        pDateFrom := to_char(current_timestamp, ''YYYY'') || ''-'' || to_char(pDateFrom, ''MM'') || ''-'' || to_char(pDateFrom, ''DD'');
                        pDateTo   := to_char(current_timestamp, ''YYYY'') || ''-'' || to_char(pDateTo, ''MM'') || ''-'' || to_char(pDateTo, ''DD'');
                        CASE WHEN pDateFrom > pDateTo THEN
                            pDateTo := to_char(to_date(pDateTo::text, ''YYYY-MM-DD'') + cast( ''1 years'' as INTERVAL ), ''YYYY-MM-DD'');
                        ELSE pDateTo := pDateTo;
                        END CASE;
                ELSE pDateTo := pDateTo;
                END CASE;
                RETURN pDateTo;
            END
            '
            LANGUAGE 'plpgsql'"
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement(
            "DROP FUNCTION tsunen_from(pDateFrom date), tsunen_to(pDateFrom date, pDateTo date)"
        );
    }
}
