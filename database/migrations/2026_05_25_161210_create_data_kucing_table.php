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
        Schema::create('data_kucing', function (Blueprint $table) {

            // UUID PRIMARY KEY
            $table->uuid('id')->primary();

            // relasi pemilik (UUID)
            $table->uuid('user_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // data kucing
            $table->string('nama_kucing');
            $table->string('ras')->nullable();
            $table->integer('umur')->nullable();
            $table->enum('jenis_kelamin', ['jantan', 'betina'])->nullable();
            $table->string('warna')->nullable();

            // info tambahan
            $table->text('ciri_khusus')->nullable();
            $table->text('alamat_pemilik')->nullable();
            $table->string('nomor_hp')->nullable();

            // qr unique
            $table->uuid('qr_code')->unique();

            // foto
            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kucing');
    }
};