<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignUlid('plan_id')->constrained('plans')->cascadeOnDelete();

            // Información general
            $table->string('provider', 100)->nullable(); // Stripe, PayPal, internal
            $table->string('provider_subscription_id', 150)->nullable()->unique(); // ID externo (Stripe ID)
            $table->string('status', 50)->default('active')->index(); // trialing, active, cancelled, past_due, etc.
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('trial_ends_at')->nullable();

            // Configuración y límites
            $table->json('features')->nullable();
            $table->json('limits')->nullable();
            $table->boolean('auto_renew')->default(true);

            // Facturación
            $table->decimal('amount_usd', 10, 2)->nullable();
            $table->string('currency', 10)->default('USD');
            $table->enum('billing_cycle', ['monthly', 'yearly'])->default('monthly');
            $table->timestamp('last_billed_at')->nullable();
            $table->timestamp('next_billing_at')->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['company_id', 'status']);
            $table->index(['plan_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
