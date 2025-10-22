<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kpi_snapshots', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Multi-tenant y referencia
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignUlid('report_definition_id')->nullable()->constrained('report_definitions')->nullOnDelete();

            // Identificación del KPI
            $table->string('kpi_key', 120)->index(); // Ej: avg_time_to_hire, candidates_per_job
            $table->string('kpi_name', 180)->nullable();
            $table->string('category', 100)->nullable(); // recruitment, performance, usage

            // Valor y periodo
            $table->decimal('value', 15, 2)->nullable();
            $table->string('unit', 50)->nullable(); // días, %, cantidad, USD, etc.
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();

            // Comparación y variaciones
            $table->decimal('previous_value', 15, 2)->nullable();
            $table->decimal('variation', 8, 2)->nullable(); // diferencia %
            $table->boolean('is_improvement')->nullable();

            // Origen y datos de respaldo
            $table->json('source_data')->nullable(); // snapshot del cálculo o query
            $table->json('metadata')->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices útiles
            $table->unique(['company_id', 'kpi_key', 'period_start', 'period_end'], 'unique_kpi_period');
            $table->index(['company_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_snapshots');
    }
};
