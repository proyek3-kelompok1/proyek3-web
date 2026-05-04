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
        Schema::create('pet_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // Kucing, Anjing, dll
            $table->string('breed')->nullable();
            $table->integer('age_months')->nullable();
            $table->decimal('weight_kg', 5, 2)->nullable();
            $table->string('photo')->nullable();
            $table->text('health_history_notes')->nullable();
            $table->boolean('needs_vaccine')->default(false);
            $table->boolean('needs_grooming')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_profiles');
    }
};
