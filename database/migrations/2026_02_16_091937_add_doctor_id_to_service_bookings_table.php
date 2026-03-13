<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('service_bookings', function (Blueprint $table) {
        $table->unsignedBigInteger('doctor_id')->nullable()->after('service_id');
        $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            //
        });
    }
};
