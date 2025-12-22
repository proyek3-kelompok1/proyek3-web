<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Nama pemberi feedback
            $table->integer('rating'); // Rating 1-5
            $table->text('message'); // Isi feedback
            $table->string('source')->default('consultation'); // consultation atau after_service
            $table->foreignId('consultation_id')->nullable()->constrained('consultations')->onDelete('set null');
            $table->string('service_type')->nullable(); // Jenis layanan (untuk after_service)
            $table->string('transaction_id')->nullable(); // ID transaksi
            $table->boolean('is_verified')->default(true); // Status verifikasi
            $table->timestamps(); // created_at dan updated_at
            
            // Index untuk performa
            $table->index('rating');
            $table->index('source');
            $table->index('created_at');
            $table->index('is_verified');
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
};