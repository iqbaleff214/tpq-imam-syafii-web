<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSppDeleteTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER spp_delete AFTER DELETE ON spp
            FOR EACH ROW
                IF OLD.status = 1
                    THEN
                        INSERT INTO `kas`
                            SET `kas`.`pengeluaran` = OLD.jumlah,
                                `kas`.`uraian` = "Pembatalan pembayaran spp",
                                `kas`.`keterangan` = CONCAT("Pembatalan spp a.n. ", (SELECT `nama_lengkap` FROM `santri` WHERE `santri`.`id` = OLD.santri_id)),
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
        DB::unprepared('DROP TRIGGER spp_delete');
    }
}
