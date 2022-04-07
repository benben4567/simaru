<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMabaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maba', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('periode_id');
            $table->integer('no_pendaftaran')->unique();
            $table->string('nama');
            $table->string('prodi_1')->nullable();
            $table->string('prodi_2')->nullable();
            $table->integer('nilai')->nullable();
            $table->string('telp')->nullable();
            $table->string('prodi_lulus')->nullable();
            $table->string('pembayaran')->nullable();
            $table->string('nim')->nullable();
            $table->string('jalur_pendaftaran')->nullable();
            $table->integer('gelombang')->nullable();
            $table->string('rekomendasi')->nullable();
            $table->string('nama_perekom')->nullable();
            $table->string('telp_perekom')->nullable();
            $table->string('file_rekom')->nullable();
            $table->string('jenis_pencairan')->nullable();
            $table->date('tgl_pengajuan')->nullable();
            $table->date('tgl_pencairan')->nullable();
            $table->date('tgl_pendaftaran')->nullable();
            $table->date('tgl_validasi')->nullable();
            $table->date('tgl_lulus')->nullable();
            $table->date('tgl_pembayaran')->nullable();
            $table->date('tgl_nim')->nullable();

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
        Schema::table('maba', function (Blueprint $table) {
            $table->dropForeign('maba_periode_id_foreign');
        });
        Schema::dropIfExists('maba');
    }
}
