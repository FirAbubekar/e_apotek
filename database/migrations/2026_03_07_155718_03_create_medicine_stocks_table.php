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
        Schema::create('medicine_stocks', function (Blueprint $table) {

    $table->id();

    $table->foreignId('medicine_id')->constrained();
    $table->foreignId('batch_id')->constrained('medicine_batches');

    $table->integer('stock_qty')->default(0);
    $table->integer('stock_in')->default(0);
    $table->integer('stock_out')->default(0);

    $table->integer('last_stock')->default(0);

    $table->unsignedBigInteger('created_by')->nullable();
    $table->unsignedBigInteger('updated_by')->nullable();

    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_stocks');
    }
};
