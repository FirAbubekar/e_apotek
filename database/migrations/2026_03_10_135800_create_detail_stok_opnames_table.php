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
        Schema::create('detail_stok_opnames', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stok_opname_id')->constrained('stok_opnames')->onDelete('cascade');
            $table->foreignId('medicine_stock_id')->constrained('medicine_stocks')->onDelete('cascade');
            $table->integer('stok_sistem');
            $table->integer('stok_fisik');
            $table->integer('selisih');
            $table->string('alasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_stok_opnames');
    }
};
