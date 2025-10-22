<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('report_runs', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('report_definition_id')->constrained('report_definitions')->cascadeOnDelete();
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignUlid('executed_by')->nullable()->constrained('users')->nullOnDelete();

            // Parámetros de ejecución
            $table->string('status', 50)->default('queued')->index(); // queued, running, completed, failed
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->json('filters_applied')->nullable(); // filtros utilizados al ejecutar
            $table->json('columns_selected')->nullable();
            $table->string('output_format', 20)->default('json'); // json, csv, pdf, xlsx
            $table->string('file_path', 255)->nullable(); // ruta del archivo generado si aplica

            // Resultados y control
            $table->unsignedInteger('row_count')->nullable();
            $table->decimal('execution_time_seconds', 8, 2)->nullable();
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices útiles
            $table->index(['company_id', 'status']);
            $table->index(['report_definition_id', 'started_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_runs');
    }
};
