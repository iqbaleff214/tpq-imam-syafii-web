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
            $table->char('kode_barang', 15)->primary();
            $table->string('nama_barang', 50);
            $table->string('satuan', 15);
            $table->integer('jumlah')->nullable(0);
            $table->string('kondisi', 15);
            $table->string('keterangan', 255)->nullable();
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
