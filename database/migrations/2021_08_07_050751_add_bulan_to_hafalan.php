<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBulanToHafalan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hafalan', function (Blueprint $table) {
            $table->string('jenis', 255)->change();
            $table->string('mulai', 15)->nullable()->change();
            $table->string('selesai', 15)->nullable()->change();
            $table->renameColumn('jenis', 'bulan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hafalan', function (Blueprint $table) {
            $table->renameColumn('bulan', 'jenis');
        });
    }
}
