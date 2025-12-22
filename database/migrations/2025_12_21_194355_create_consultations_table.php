<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Nama lengkap
            $table->string('email'); // Email
            $table->string('phone')->nullable(); // Telepon (opsional)
            $table->string('pet_type'); // Jenis hewan: kucing, anjing, dll
            $table->json('services')->nullable(); // Layanan yang dipilih (array dalam JSON)
            $table->text('message'); // Pesan konsultasi
            $table->timestamps(); // created_at dan updated_at
            
            // Index untuk performa pencarian
            $table->index('email');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultations');
    }
};