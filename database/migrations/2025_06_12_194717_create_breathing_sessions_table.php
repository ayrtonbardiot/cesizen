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
        Schema::create('breathing_sessions', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')
            ->nullable() // ← rend la session anonyme possible
            ->constrained()
            ->cascadeOnDelete();

            $table->foreignId('breathing_exercise_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('ended_at')->nullable();

            $table->unsignedInteger('duration_seconds')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breathing_sessions');
    }
};
