<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('user_id');

            $table->string('order_id')->unique();

            $table->integer('amount');

            $table->enum('status', [
                'pending',
                'paid',
                'failed',
                'expired',
                'cancelled'
            ])->default('pending');

            $table->string('payment_gateway')->nullable(); // midtrans,xendit,dll
            $table->string('payment_type')->nullable(); // qris,va,gopay,dll
            $table->string('transaction_id')->nullable();

            $table->json('payload')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};