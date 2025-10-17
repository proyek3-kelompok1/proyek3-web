<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemilik');
            $table->string('email');
            $table->string('telepon');
            $table->string('nama_hewan');
            $table->string('jenis_hewan');
            $table->string('ras');
            $table->integer('umur');
            $table->string('dokter');
            $table->string('layanan');
            $table->datetime('tanggal_jam');
            $table->text('keluhan');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};