<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profil', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('email')->nullable();
            $table->string('alamat', 255);
            $table->string('no_telp', 15)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('deskripsi', 255)->nullable();
            $table->string('visi', 255);
            $table->string('facebook', 255)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('twitter', 255)->nullable();
            $table->string('whatsapp', 255)->nullable();
            $table->boolean('is_active')->nullable()->default(false);
            $table->boolean('is_pendaftaran')->nullable()->default(false);
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
        Schema::dropIfExists('profil');
    }
}
