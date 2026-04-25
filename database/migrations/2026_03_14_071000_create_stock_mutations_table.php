<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_mutations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_stock_id')->constrained('medicine_stocks')->onDelete('cascade');
            $table->enum('type', ['Masuk', 'Keluar', 'Opname', 'Penyesuaian']);
            $table->integer('qty_change');
            $table->integer('qty_before');
            $table->integer('qty_after');
            $table->string('reference')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_mutations');
    }
};
