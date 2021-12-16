<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('event_id');
            $table->string('nip');
            $table->string('nama_lengkap');
            $table->string('no_hp');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->string('jk');
            $table->unsignedBigInteger('pekerjaan_id');
            $table->string('pangkat');
            $table->string('jabatan');
            $table->longText('instansi');
            $table->unsignedBigInteger('kabupaten_id');
            $table->string('npwp');
            $table->string('nama_bank');
            $table->string('no_rekening');
            $table->double('biaya_perjalanan');
            $table->integer('status_pendaftaran_ulang');
            // $table->integer('nomor_antrian');
            // $table->string('jenis_pendaftaran');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('event')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pekerjaan_id')->references('id')->on('pekerjaan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kabupaten_id')->references('id')->on('kabupaten')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftaran');
    }
}
