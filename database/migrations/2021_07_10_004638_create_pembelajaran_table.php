<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelajaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('bacaan', 50);
            $table->string('mulai', 15);
            $table->string('selesai', 15);
            $table->string('nilai', 15);
            $table->string('keterangan', 255)->nullable();
            $table->char('nis', 21);
            $table->foreignId('pengajar_id')->constrained('pengajar');
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
        Schema::dropIfExists('pembelajaran');
    }
}
