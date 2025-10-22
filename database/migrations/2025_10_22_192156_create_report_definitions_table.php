<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('report_definitions', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Multi-tenant
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();

            // Información del reporte
            $table->string('name', 150);
            $table->string('slug', 160)->unique(); // identificador del tipo de reporte
            $table->string('category', 100)->nullable(); // ejemplo: recruitment, performance, usage
            $table->text('description')->nullable();

            // Configuración técnica
            $table->string('data_source', 150)->nullable(); // tabla o vista usada como origen
            $table->json('filters_schema')->nullable(); // definición de filtros configurables
            $table->json('columns')->nullable(); // columnas disponibles y su formato
            $table->json('aggregations')->nullable(); // agregaciones predefinidas
            $table->boolean('is_active')->default(true);

            // Control de acceso
            $table->json('allowed_roles')->nullable(); // roles con permiso para ejecutarlo
            $table->boolean('is_system')->default(false); // reportes base del sistema

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->unique(['company_id', 'name']);
            $table->index(['company_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_definitions');
    }
};
