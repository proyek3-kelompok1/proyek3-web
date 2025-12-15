// database/migrations/2025_10_20_110526_create_feedbacks_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('rating');
            $table->text('message')->nullable();
            $table->string('service_type')->nullable(); // Jenis layanan
            $table->string('transaction_id')->nullable(); // ID transaksi/booking
            $table->string('source')->default('consultation'); // 'consultation' atau 'after_service'
            $table->foreignId('consultation_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('is_read')->default(false);
            $table->boolean('is_verified')->default(true); // Auto verified
            $table->json('metadata')->nullable(); // Metadata tambahan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
};