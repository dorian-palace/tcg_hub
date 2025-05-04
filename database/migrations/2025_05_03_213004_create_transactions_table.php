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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['sale', 'trade', 'auction'])->default('sale');
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled', 'disputed'])->default('pending');
            $table->dateTime('transaction_date');
            $table->text('notes')->nullable();
            $table->string('transaction_reference')->unique()->nullable();
            $table->json('items_exchanged')->nullable(); // JSON to store details of cards exchanged
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
