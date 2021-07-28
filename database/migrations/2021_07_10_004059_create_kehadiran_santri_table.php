<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKehadiranSantriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kehadiran_santri', function (Blueprint $table) {
            $table->id();
            $table->string('nilai_adab', 15)->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->string('bulan');
            $table->text('catatan')->nullable();
            $table->foreignId('santri_id')->constrained('santri');
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
        Schema::dropIfExists('kehadiran_santri');
    }
}
