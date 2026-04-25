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
        Schema::create('cash_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique(); // KSM-20240314-001 or KSK-20240314-001
            $table->enum('type', ['Masuk', 'Keluar']);
            $table->string('category'); // Modal Awal, Penjualan, Operasional, dll
            $table->decimal('amount', 14, 2);
            $table->text('description')->nullable();
            $table->timestamp('transaction_date');
            $table->string('reference_type')->nullable(); // Penjualan, Return, etc.
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_transactions');
    }
};
