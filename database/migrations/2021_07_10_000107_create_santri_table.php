<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSantriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('santri', function (Blueprint $table) {
            $table->id();
            $table->char('nis', 21)->unique();
            $table->string('nama_lengkap', 50);
            $table->string('nama_panggilan', 15);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('alamat', 255);
            $table->tinyInteger('anak_ke')->default(1);
            $table->tinyInteger('jumlah_saudara')->default(0);
            $table->string('status', 15)->default('Calon');
            $table->string('foto', 255)->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('kelas_id')->nullable()->constrained('kelas');
            $table->foreignId('spp_opsi_id')->constrained('spp_opsi');
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
        Schema::dropIfExists('santri');
    }
}
