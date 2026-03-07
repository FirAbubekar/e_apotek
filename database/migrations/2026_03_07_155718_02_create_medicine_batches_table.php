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
      Schema::create('medicine_batches', function (Blueprint $table) {

    $table->id();

    $table->foreignId('medicine_id')
          ->constrained('medicines')
          ->cascadeOnDelete();

    $table->string('batch_number');

    $table->date('expired_date');

    $table->decimal('purchase_price',12,2);
    $table->decimal('selling_price',12,2);

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
        Schema::dropIfExists('medicine_batches');
    }
};
