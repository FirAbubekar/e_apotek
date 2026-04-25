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
        Schema::table('penjualan', function (Blueprint $table) {
            $table->decimal('subtotal', 14, 2)->after('tanggal_penjualan')->default(0);
            $table->decimal('diskon', 14, 2)->after('subtotal')->default(0);
            $table->decimal('ppn', 14, 2)->after('diskon')->default(0);
            $table->string('tipe_penjualan')->after('ppn')->default('Retail'); // Retail, Resep
            $table->string('metode_pembayaran')->after('tipe_penjualan')->default('Tunai'); // Tunai, Debit, Transfer, QRIS
            $table->string('dokter')->nullable()->after('metode_pembayaran');
            $table->string('no_resep')->nullable()->after('dokter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'diskon', 'ppn', 'tipe_penjualan', 'metode_pembayaran', 'dokter', 'no_resep']);
        });
    }
};
