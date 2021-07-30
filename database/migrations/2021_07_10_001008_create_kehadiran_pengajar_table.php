<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKehadiranPengajarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kehadiran_pengajar', function (Blueprint $table) {
            $table->id();
            $table->time('datang');
            $table->time('pulang');
            $table->string('keterangan', 255)->nullable();
            $table->foreignId('pengajar_id')->constrained('pengajar');
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
        Schema::dropIfExists('kehadiran_pengajar');
    }
}
