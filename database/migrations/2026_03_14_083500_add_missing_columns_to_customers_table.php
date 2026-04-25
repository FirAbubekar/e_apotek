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
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'nama')) {
                $table->string('nama')->after('id');
            }
            if (!Schema::hasColumn('customers', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('customers', 'alamat')) {
                $table->text('alamat')->nullable()->after('no_hp');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['nama', 'no_hp', 'alamat']);
        });
    }
};
