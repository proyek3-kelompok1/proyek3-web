<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('consultation_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->string('status')->default('active'); // active, closed
            $table->timestamps();
        });

        Schema::create('consultation_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('consultation_sessions')->onDelete('cascade');
            $table->enum('sender_type', ['user', 'doctor']);
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultation_messages');
        Schema::dropIfExists('consultation_sessions');
    }
};
