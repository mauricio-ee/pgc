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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->enum('method', ['mercado_pago', 'transfer'])->default('mercado_pago');
            $table->enum('status', ['pending', 'completed', 'failed', 'canceled'])->default('pending');
            $table->decimal('amount', 10, 2);
            $table->string('mercado_pago_id')->nullable(); // ID de preferencia en MP
            $table->string('transaction_id')->nullable();
            $table->text('metadata')->nullable(); // JSON con datos de respuesta
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            
            $table->index('order_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
