<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSppInsertTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER spp_insert AFTER INSERT ON spp
            FOR EACH ROW
                IF NEW.status = 2
                    THEN
                        INSERT INTO `kas`
                            SET `kas`.`pemasukan` = NEW.jumlah,
                                `kas`.`uraian` = "Pembayaran spp",
                                `kas`.`keterangan` = CONCAT("Pembayaran spp a.n. ", (SELECT `nama_lengkap` FROM `santri` WHERE `santri`.`id` = NEW.santri_id)),
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
        DB::unprepared('DROP TRIGGER spp_insert');
    }
}
