<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->char('kode_barang', 15)->unique();
            $table->string('nama_barang', 50);
            $table->string('satuan', 15);
            $table->integer('jumlah_baik');
            $table->integer('jumlah_rusak');
            $table->string('keterangan', 255)->nullable();
            $table->string('foto', 255)->nullable();
            $table->foreignId('admin_id')->constrained('admin');
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
        Schema::dropIfExists('inventaris');
    }
}
