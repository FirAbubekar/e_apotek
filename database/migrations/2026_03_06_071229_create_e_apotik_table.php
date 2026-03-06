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
        Schema::create('e_apotik', function (Blueprint $table) {
            $table->id();
            $table->string('nama_apotek');
            $table->text('alamat');
            $table->string('no_telp');
            $table->string('email');
            $table->string('sip')->nullable();
            $table->string('sia')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_apotik');
    }
};
