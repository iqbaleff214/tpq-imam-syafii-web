<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilRekeningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profil_rekening', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('bank');
            $table->string('rekening');
            $table->string('keterangan')->nullable();
            $table->foreignId('profil_id')->constrained('profil');
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
        Schema::dropIfExists('profil_rekening');
    }
}
