<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHafalanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hafalan', function (Blueprint $table) {
            $table->id();
            $table->string('hafalan', 50);
            $table->string('mulai', 15);
            $table->string('selesai', 15)->nullable();
            $table->string('jenis', 15);
            $table->string('nilai', 15);
            $table->string('keterangan', 255)->nullable();
            $table->foreignId('santri_id')->constrained('santri');
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
        Schema::dropIfExists('hafalan');
    }
}
