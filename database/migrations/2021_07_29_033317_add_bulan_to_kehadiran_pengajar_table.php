<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBulanToKehadiranPengajarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kehadiran_pengajar', function (Blueprint $table) {
            $table->string('bulan', 50)->after('pulang');
            $table->time('pulang')->nullable()->change();
            $table->time('datang')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kehadiran_pengajar', function (Blueprint $table) {
            $table->dropColumn('bulan');
        });
    }
}
