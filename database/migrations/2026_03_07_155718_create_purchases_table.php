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
        Schema::create('purchases', function (Blueprint $table) {

    $table->id();
    $table->string('purchase_number')->unique();

    $table->foreignId('supplier_id')->constrained();

    $table->date('purchase_date');

    $table->decimal('total_amount',12,2);
    $table->decimal('discount',12,2)->default(0);
    $table->decimal('tax',12,2)->default(0);

    $table->decimal('grand_total',12,2);

    $table->string('status');

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
        Schema::dropIfExists('purchases');
    }
};
