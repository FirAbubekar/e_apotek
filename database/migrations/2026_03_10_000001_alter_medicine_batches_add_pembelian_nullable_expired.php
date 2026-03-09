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
        Schema::table('medicine_batches', function (Blueprint $table) {
            // Jadikan expired_date nullable (batch dari pembelian mungkin belum diketahui)
            $table->date('expired_date')->nullable()->change();

            // Tambah relasi ke pembelian (nullable, untuk trace batch ke transaksi)
            $table->unsignedBigInteger('pembelian_id')->nullable()->after('medicine_id');
            $table->foreign('pembelian_id')->references('id')->on('pembelian')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicine_batches', function (Blueprint $table) {
            $table->dropForeign(['pembelian_id']);
            $table->dropColumn('pembelian_id');
            $table->date('expired_date')->nullable(false)->change();
        });
    }
};
