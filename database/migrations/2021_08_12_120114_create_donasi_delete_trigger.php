<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDonasiDeleteTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER donasi_delete AFTER DELETE ON donasi
            FOR EACH ROW
                IF OLD.status = 1
                    THEN
                        INSERT INTO `kas`
                            SET `kas`.`pengeluaran` = OLD.jumlah,
                                `kas`.`uraian` = "Pembatalan donasi",
                                `kas`.`keterangan` = CONCAT("Donasi dibatalkan a.n. ", OLD.nama),
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
        DB::unprepared('DROP TRIGGER donasi_delete');
    }
}
