<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDonasiAcceptTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER donasi_accept AFTER UPDATE ON donasi
            FOR EACH ROW
                IF OLD.status = 0 AND NEW.status = 1
                    THEN
                        INSERT INTO `kas`
                            SET `kas`.`pemasukan` = NEW.jumlah,
                                `kas`.`uraian` = CONCAT("Donasi a.n. ", NEW.nama),
                                `kas`.`keterangan` = NEW.keterangan,
                                `kas`.`created_at` = CURRENT_TIMESTAMP();
                END IF;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER donasi_accept');
    }
}
