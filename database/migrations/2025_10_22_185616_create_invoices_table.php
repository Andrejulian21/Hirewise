<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignUlid('subscription_id')->nullable()->constrained('subscriptions')->nullOnDelete();

            // Identificación y referencia externa
            $table->string('invoice_number', 100)->unique();
            $table->string('provider', 100)->nullable(); // Stripe, PayPal, local
            $table->string('provider_invoice_id', 150)->nullable()->unique(); // ID externo del proveedor

            // Montos y divisa
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->string('currency', 10)->default('USD');

            // Fechas clave
            $table->timestamp('issued_at')->nullable()->index();
            $table->timestamp('due_at')->nullable();
            $table->timestamp('paid_at')->nullable();

            // Estado
            $table->enum('status', ['draft','issued','paid','failed','cancelled'])->default('draft')->index();

            // Detalle y metadatos
            $table->json('line_items')->nullable(); // detalle de cargos y conceptos
            $table->json('metadata')->nullable();   // datos adicionales del proveedor o auditoría

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices adicionales
            $table->index(['company_id', 'status']);
            $table->index(['subscription_id', 'issued_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
