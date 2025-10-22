<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usage_metrics', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignUlid('subscription_id')->nullable()->constrained('subscriptions')->nullOnDelete();

            // Métricas principales
            $table->string('metric_key', 120); // Ej: job_postings_created, cvs_analyzed, ai_requests
            $table->unsignedBigInteger('value')->default(0); // valor acumulado
            $table->string('period', 20)->default('monthly'); // daily, weekly, monthly, yearly

            // Control temporal
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->timestamp('last_updated_at')->nullable();

            // Límite y exceso
            $table->unsignedBigInteger('limit')->nullable(); // límite asignado por plan
            $table->boolean('is_exceeded')->default(false);

            // Datos adicionales
            $table->json('metadata')->nullable(); // detalles por origen o evento

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->unique(['company_id', 'metric_key', 'period_start', 'period_end'], 'usage_unique_period');
            $table->index(['company_id', 'metric_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usage_metrics');
    }
};
