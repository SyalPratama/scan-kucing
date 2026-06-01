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
        Schema::table('payments', function (Blueprint $table) {
            // Ditambahkan after('user_id') agar posisi kolom rapi setelah kolom user_id
            $table->foreignId('package_id')
                  ->after('user_id')
                  ->constrained('packages')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu, baru hapus kolomnya
            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id');
        });
    }
};