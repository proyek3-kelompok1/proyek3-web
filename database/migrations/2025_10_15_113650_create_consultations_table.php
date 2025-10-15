<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('consultations')) {
            Schema::create('consultations', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('phone')->nullable();
                $table->string('pet_type');
                $table->json('services')->nullable();
                $table->text('message');
                $table->timestamps();
            });
        } else {
            // Jika tabel sudah ada, tambahkan kolom yang mungkin belum ada
            Schema::table('consultations', function (Blueprint $table) {
                if (!Schema::hasColumn('consultations', 'pet_type')) {
                    $table->string('pet_type')->after('phone');
                }
                if (!Schema::hasColumn('consultations', 'services')) {
                    $table->json('services')->nullable()->after('pet_type');
                }
            });
        }
    }

    public function down()
    {
        // Jangan drop tabel di sini untuk menghindari kehilangan data
        // Schema::dropIfExists('consultations');
    }
};