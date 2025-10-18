<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rekam_medis')->unique();
            $table->foreignId('service_booking_id')->constrained()->onDelete('cascade');
            $table->string('nama_pemilik');
            $table->string('nama_hewan');
            $table->string('jenis_hewan');
            $table->string('ras');
            $table->integer('umur');
            $table->string('berat_badan')->nullable();
            $table->string('suhu_tubuh')->nullable();
            $table->text('keluhan_utama');
            $table->text('diagnosa');
            $table->text('tindakan')->nullable();
            $table->text('resep_obat')->nullable();
            $table->text('catatan_dokter')->nullable();
            $table->string('dokter');
            $table->date('tanggal_pemeriksaan');
            $table->date('kunjungan_berikutnya')->nullable();
            $table->enum('status', ['selesai', 'rawat', 'kontrol'])->default('selesai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_records');
    }
};