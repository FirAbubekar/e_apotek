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
        Schema::create('cashier_closings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamp('opening_time')->nullable();
            $table->timestamp('closing_time')->nullable();
            $table->decimal('opening_cash', 14, 2);
            $table->decimal('total_cash_sales', 14, 2);
            $table->decimal('total_non_cash_sales', 14, 2);
            $table->decimal('total_income', 14, 2);
            $table->decimal('total_expense', 14, 2);
            $table->decimal('expected_cash', 14, 2);
            $table->decimal('actual_cash', 14, 2);
            $table->decimal('difference', 14, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashier_closings');
    }
};
