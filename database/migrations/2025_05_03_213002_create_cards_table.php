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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('set_name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('rarity')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('avg_market_price', 10, 2)->nullable();
            $table->string('language')->default('en');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
