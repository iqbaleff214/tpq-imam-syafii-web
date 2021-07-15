<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSantriWaliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('santri_wali', function (Blueprint $table) {
            $table->id();
            $table->string('nama_wali', 50);
            $table->string('hubungan', 50)->nullable();
            $table->string('no_telp', 15)->nullable();
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
        Schema::dropIfExists('santri_wali');
    }
}
