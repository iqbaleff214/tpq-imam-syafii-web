<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHonorAcceptTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER honor_accept AFTER UPDATE ON honor
            FOR EACH ROW
                IF OLD.status = 0 AND NEW.status = 1
                    THEN
                        INSERT INTO `kas`
                            SET `kas`.`pengeluaran` = NEW.jumlah,
                                `kas`.`uraian` = "Pembayaran honor",
                                `kas`.`keterangan` = CONCAT("Pembayaran honor pengajar a.n. ", (SELECT `nama` FROM `pengajar` WHERE `pengajar`.`id` = NEW.pengajar_id)),
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
        DB::unprepared('DROP TRIGGER honor_accept');
    }
}
