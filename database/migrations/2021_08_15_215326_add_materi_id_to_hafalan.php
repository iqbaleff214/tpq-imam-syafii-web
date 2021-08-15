<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMateriIdToHafalan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hafalan', function (Blueprint $table) {
            $table->foreignId('materi_id')->constrained('materi');
            $table->dropColumn('hafalan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hafalan', function (Blueprint $table) {
            $table->string('hafalan');
            $table->dropForeign(['materi_id']);
        });
    }
}
