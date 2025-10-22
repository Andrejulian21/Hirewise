<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('credits_ledger', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignUlid('subscription_id')->nullable()->constrained('subscriptions')->nullOnDelete();
            $table->foreignUlid('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Movimiento de crédito
            $table->enum('type', ['credit', 'debit'])->index(); // ingreso o gasto
            $table->string('source', 120)->nullable(); // plan, extra_purchase, ai_job, etc.
            $table->string('reference_id', 120)->nullable(); // id externo relacionado
            $table->decimal('amount', 10, 2)->default(0); // cantidad de créditos

            // Control temporal
            $table->timestamp('transaction_date')->nullable();
            $table->string('currency', 10)->default('USD'); // opcional, para monetizar créditos
            $table->decimal('value_usd', 10, 2)->nullable(); // valor equivalente

            // Estado
            $table->string('status', 50)->default('completed'); // pending, completed, refunded, expired
            $table->boolean('is_reversal')->default(false);

            // Descripción y metadatos
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['company_id', 'type']);
            $table->index(['transaction_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credits_ledger');
    }
};
