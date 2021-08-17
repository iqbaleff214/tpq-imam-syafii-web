<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSppAcceptTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER spp_accept AFTER UPDATE ON spp
            FOR EACH ROW
                IF OLD.status = 1 AND NEW.status = 2
                    THEN
                        INSERT INTO `kas`
                            SET `kas`.`pemasukan` = NEW.jumlah,
                                `kas`.`uraian` = "Pembayaran SPP",
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
        DB::unprepared('DROP TRIGGER spp_accept');
    }
}
