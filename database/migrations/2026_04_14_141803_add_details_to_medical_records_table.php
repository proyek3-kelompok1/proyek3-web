<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->string('alamat')->nullable()->after('nama_pemilik');
            $table->string('telepon')->nullable()->after('alamat');
            $table->string('ciri_warna')->nullable()->after('ras');
            $table->string('jenis_kelamin')->nullable()->after('ciri_warna');
            $table->text('prognosa')->nullable()->after('diagnosa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'telepon', 'ciri_warna', 'jenis_kelamin', 'prognosa']);
        });
    }
};
