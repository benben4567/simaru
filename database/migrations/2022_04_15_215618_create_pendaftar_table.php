<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('periode_id');
            $table->integer('no_pendaftaran')->unique();
            $table->string('nama');
            $table->string('prodi_1')->nullable();
            $table->string('prodi_2')->nullable();
            $table->integer('gelombang')->nullable();
            $table->string('bayar_pendaftaran')->nullable();
            $table->string('jalur')->nullable();
            $table->timestamps();

            $table->foreign('periode_id')->references('id')->on('periode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->dropForeign('pendaftar_periode_id_foreign');
        });
        Schema::dropIfExists('pendaftar');
    }
}
