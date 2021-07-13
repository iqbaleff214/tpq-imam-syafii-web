<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHonorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('honor', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('jumlah')->default(0);
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
        Schema::dropIfExists('honor');
    }
}
