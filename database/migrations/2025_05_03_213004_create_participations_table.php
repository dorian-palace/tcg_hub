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
        Schema::create('participations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['registered', 'confirmed', 'cancelled', 'attended', 'no_show'])->default('registered');
            $table->dateTime('registration_date');
            $table->boolean('payment_received')->default(false);
            $table->text('notes')->nullable();
            $table->integer('final_ranking')->nullable();
            $table->timestamps();
            
            // Unique constraint to prevent duplicate registrations
            $table->unique(['user_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participations');
    }
};
