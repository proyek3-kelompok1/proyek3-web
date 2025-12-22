<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('service_bookings', function (Blueprint $table) {
            $table->id();
            // $table->string('nama_pemilik');
            // $table->string('email');
            // $table->string('telepon');
            $table->string('nama_hewan');
            $table->string('jenis_hewan');
            $table->string('ras');
            $table->integer('umur');
            $table->string('service_type');
            $table->string('doctor');
            $table->date('booking_date');
            $table->string('booking_time');
            $table->text('catatan')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->string('booking_code')->unique();
            $table->integer('nomor_antrian')->nullable(); // Tambah field nomor antrian
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_bookings');
    }
};