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
        Schema::create('return_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('no_return_pj')->unique();
            $table->foreignId('penjualan_id')->constrained('penjualan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->date('tanggal_return');
            $table->decimal('total_return', 15, 2);
            $table->text('alasan')->nullable();
            $table->timestamps();
        });

        Schema::create('detail_return_penjualan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_penjualan_id')->constrained('return_penjualan')->onDelete('cascade');
            $table->foreignId('obat_id')->constrained('medicines');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_return_penjualan');
        Schema::dropIfExists('return_penjualan');
    }
};
