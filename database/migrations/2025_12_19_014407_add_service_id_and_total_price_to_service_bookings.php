<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            // Tambah kolom jika belum ada
            if (!Schema::hasColumn('service_bookings', 'service_id')) {
                $table->unsignedBigInteger('service_id')->nullable()->after('service_type');
                $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('service_bookings', 'total_price')) {
                $table->decimal('total_price', 10, 2)->nullable()->after('catatan');
            }
        });
    }

    public function down()
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            if (Schema::hasColumn('service_bookings', 'service_id')) {
                $table->dropForeign(['service_id']);
                $table->dropColumn('service_id');
            }
            
            if (Schema::hasColumn('service_bookings', 'total_price')) {
                $table->dropColumn('total_price');
            }
        });
    }
};