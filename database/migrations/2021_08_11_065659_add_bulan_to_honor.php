<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBulanToHonor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('honor', function (Blueprint $table) {
            $table->string('bulan')->after('keterangan');
            $table->boolean('status')->after('keterangan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('honor', function (Blueprint $table) {
            $table->dropColumn('bulan');
            $table->dropColumn('status');
        });
    }
}
