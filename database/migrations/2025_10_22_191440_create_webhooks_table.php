<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('webhooks', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relación multi-tenant
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();

            // Configuración del webhook
            $table->string('name', 150);
            $table->string('endpoint_url', 255);
            $table->json('events')->nullable(); // lista de eventos: candidate.created, job.updated, etc.
            $table->string('secret_token', 255)->nullable(); // firma para validación
            $table->boolean('is_active')->default(true);

            // Control y métricas
            $table->unsignedBigInteger('success_count')->default(0);
            $table->unsignedBigInteger('failure_count')->default(0);
            $table->timestamp('last_triggered_at')->nullable();
            $table->timestamp('last_failed_at')->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->unique(['company_id', 'endpoint_url']);
            $table->index(['company_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhooks');
    }
};
