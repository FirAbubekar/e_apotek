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
        Schema::create('medicines', function (Blueprint $table) {

    $table->id();

    $table->string('medicine_code')->unique();
    $table->string('barcode')->unique();

    $table->string('medicine_name');

    $table->foreignId('category_id')->constrained();
    $table->foreignId('unit_id')->constrained();
    $table->foreignId('supplier_id')->constrained();

    $table->decimal('purchase_price',12,2);
    $table->decimal('selling_price',12,2);

    $table->integer('minimum_stock')->default(0);

    $table->text('description')->nullable();

    $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('medicines');
    }
};
