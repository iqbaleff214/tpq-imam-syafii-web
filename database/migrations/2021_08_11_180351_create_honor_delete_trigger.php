<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHonorDeleteTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER honor_delete AFTER DELETE ON honor
            FOR EACH ROW
                IF OLD.status = 1
                    THEN
                        INSERT INTO `kas`
                            SET `kas`.`pemasukan` = OLD.jumlah,
                                `kas`.`uraian` = "Pengembalian honor",
                                `kas`.`keterangan` = CONCAT("Pembatalan pembayaran honor pengajar a.n. ", (SELECT `nama` FROM `pengajar` WHERE `pengajar`.`id` = OLD.pengajar_id)),
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
        DB::unprepared('DROP TRIGGER honor_delete');
    }
}
