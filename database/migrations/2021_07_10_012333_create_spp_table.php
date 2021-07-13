<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spp', function (Blueprint $table) {
            $table->id();
            $table->string('bulan', 50);
            $table->unsignedInteger('jumlah');
            $table->string('bukti', 255)->nullable();
            $table->string('status', 15);
            $table->string('keterangan', 255)->nullable();
            $table->char('nis', 21);
            $table->foreign('nis')->references('nis')->on('santri');
            $table->timestamps();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spp');
    }
}
