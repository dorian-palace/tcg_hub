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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('card_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->enum('condition', ['mint', 'near_mint', 'excellent', 'good', 'played', 'poor'])->default('near_mint');
            $table->boolean('for_trade')->default(false);
            $table->boolean('for_sale')->default(false);
            $table->decimal('price', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Unique constraint to prevent duplicate entries
            $table->unique(['user_id', 'card_id', 'condition']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
